<!doctype html>
<html lang="en">
  <head>
    <title>Face Tracker</title>
    <meta charset="utf-8">
    <style>
      @import url(https://fonts.googleapis.com/css?family=Lato:300italic,700italic,300,700);

      body {
        font-family: 'Lato';
        background-color: #f0f0f0;
        margin: 0px auto;
        max-width: 1150px;
      }

      #overlay, #webgl {
        position: absolute;
        top: 0px;
        left: 0px;
        -o-transform : scaleX(-1);
        -webkit-transform : scaleX(-1);
        transform : scaleX(-1);
        -ms-filter : fliph; /*IE*/
        filter : fliph; /*IE*/

      }

      #videoel {
        -o-transform : scaleX(-1);
        -webkit-transform : scaleX(-1);
        transform : scaleX(-1);
        -ms-filter : fliph; /*IE*/
        filter : fliph; /*IE*/

      }

      #container {
        position : relative;
        width : 370px;
      }

      #content {
        margin-top : 50px;
        margin-left : auto;
        margin-right : auto;
        max-width: 600px;
      }
      #canvas {
        position: absolute;
        left: 0;
        top: 0;
      }

      h2 {
        font-weight : 400;
      }

      .masks {
        display: none;
      }

      .btn {
        font-family: 'Lato';
        font-size: 16px;
      }

      #webgl2 {
        display : none;
      }

      #controls {
        text-align : center;
      }
    </style>
    <script>
      // getUserMedia only works over https in Chrome 47+, so we redirect to https. Also notify user if running from file.
      if (window.location.protocol == "file:") {
        alert("You seem to be running this example directly from a file. Note that these examples only work when served from a server or localhost due to canvas cross-domain restrictions.");
      } else if (window.location.hostname !== "localhost" && window.location.protocol !== "https:"){
        window.location.protocol = "https";
      }
    </script>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-32642923-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </head>
  <body>
    <script src="../examples/js/libs/dat.gui.min.js"></script>
    <script src="../examples/js/libs/utils.js"></script>
    <script src="../examples/js/libs/webgl-utils.js"></script>
    <script src="../build/clmtrackr.js"></script>
    <script src="../models/model_pca_20_svm.js"></script>
    <script src="../examples/js/libs/Stats.js"></script>
    <script src="../examples/js/face_deformer.js"></script>
    <script src="../examples/js/libs/jquery.min.js"></script>
    <script src="../examples/js/libs/poisson_new.js"></script>

    <div id="content">
        <div id="container">
        <video id="videoel" width="400" height="300" preload="auto" playsinline autoplay>
        </video>
        <canvas id="overlay" width="400" height="300"></canvas>
        <canvas id="webgl" width="400" height="300"></canvas>
      </div>
      <br/>
      <div id="controls">
        <input class="btn" type="button" value="wait, loading video & images" disabled="disabled" onclick="startVideo()" id="startbutton"></input>
        
      </div>
      
      
      <canvas id="webgl2" width="400" height="300"></canvas>
      <script>
        // when everything is ready, automatically start everything ?

        var vid = document.getElementById('videoel');
        var vid_width = vid.width;
        var vid_height = vid.height;
        var overlay = document.getElementById('overlay');
        var overlayCC = overlay.getContext('2d');
        var webgl_overlay = document.getElementById('webgl');
        var webgl_overlay2 = document.getElementById('webgl2');

        // canvas for copying the warped face to
        var newcanvas = document.createElement('CANVAS');
        newcanvas.width = vid_width;
        newcanvas.height = vid_height;
        // canvas for copying videoframes to
        var videocanvas = document.createElement('CANVAS');
        videocanvas.width = vid_width;
        videocanvas.height = vid_height;
        // canvas for masking
        var maskcanvas = document.createElement('CANVAS');
        maskcanvas.width = vid_width;
        maskcanvas.height = vid_height;

        /*********** Setup of video/webcam and checking for webGL support *********/

        var videoReady = false;
        var imagesReady = false;

        function enablestart() {
          if (videoReady) {
            var startbutton = document.getElementById('startbutton');
            startbutton.value = "start";
            startbutton.disabled = null;
          }
        }

        $(window).load(function() {
          enablestart();
        });

        var insertAltVideo = function(video) {
          if (supports_video()) {
            if (supports_webm_video()) {
              video.src = "./media/cap13_edit2.webm";
            } else if (supports_h264_baseline_video()) {
              video.src = "./media/cap13_edit2.mp4";
            } else {
              return false;
            }
            fd.init(webgl_overlay);
            fd2.init(webgl_overlay2);
            return true;
          } else return false;
        }

        function adjustVideoProportions() {
          // resize overlay and video if proportions are not 4:3
          // keep same height, just change width
          var proportion = vid.videoWidth/vid.videoHeight;
          vid_width = Math.round(vid_height * proportion);
          vid.width = vid_width;
          overlay.width = vid_width;
          webgl_overlay.width = vid_width;
          webgl_overlay2.width = vid_width;
          newcanvas.width = vid_width;
          videocanvas.width = vid_width;
          maskcanvas.width = vid_width;
          webGLContext.viewport(0,0,webGLContext.canvas.width,webGLContext.canvas.height);
          webGLContext2.viewport(0,0,webGLContext2.canvas.width,webGLContext2.canvas.height);
        }

        // check whether browser supports webGL
        var webGLContext;
        var webGLContext2;
        if (window.WebGLRenderingContext) {
          webGLContext = webgl_overlay.getContext('webgl') || webgl_overlay.getContext('experimental-webgl');
          webGLContext2 = webgl_overlay2.getContext('webgl') || webgl_overlay2.getContext('experimental-webgl');
          if (!webGLContext || !webGLContext.getExtension('OES_texture_float')) {
            webGLContext = null;
          }
        }
        if (webGLContext == null) {
          alert("Your browser does not seem to support WebGL. Unfortunately this face mask example depends on WebGL, so you'll have to try it in another browser. :(");
        }

        function gumSuccess( stream ) {
          // add camera stream if getUserMedia succeeded
          if ("srcObject" in vid) {
            vid.srcObject = stream;
          } else {
            vid.src = (window.URL && window.URL.createObjectURL(stream));
          }
          vid.onloadedmetadata = function() {
            adjustVideoProportions();
            fd.init(webgl_overlay);
            fd2.init(webgl_overlay2);
            vid.play();
          }
          vid.onresize = function() {
            adjustVideoProportions();
            fd.init(webgl_overlay);
            fd2.init(webgl_overlay2);
            if (trackingStarted) {
              ctrack.stop();
              ctrack.reset();
              ctrack.start(vid);
            }
            cancelRequestAnimFrame(detectionRequest);
            cancelRequestAnimFrame(animationRequest);
            overlayCC.clearRect(0, 0, vid_width, vid_height);
            drawGridLoop();
          }
        }

        function gumFail() {
          // fall back to video if getUserMedia failed
          insertAltVideo(vid);
          alert("There was some problem trying to fetch video from your webcam, using a fallback video instead.");
        }

        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
        window.URL = window.URL || window.webkitURL || window.msURL || window.mozURL;

        // check for camerasupport
        if (navigator.mediaDevices) {
          navigator.mediaDevices.getUserMedia({video : true}).then(gumSuccess).catch(gumFail);
        } else if (navigator.getUserMedia) {
          navigator.getUserMedia({video : true}, gumSuccess, gumFail);
        } else {
          insertAltVideo(vid);
          alert("Your browser does not seem to support getUserMedia, using a fallback video instead.");
        }

        vid.addEventListener('canplay', function() {videoReady = true;enablestart();}, false);

        /*********** Code for face substitution *********/

        var animationRequest, detectionRequest;
        var positions;

        var ctrack = new clm.tracker();
        ctrack.init(pModel);
        var trackingStarted = false;

        document.getElementById('selectmask').addEventListener('change', updateMask, false);

        function updateMask(el) {
          currentMask = parseInt(el.target.value, 10);
          var positions = ctrack.getCurrentPosition();
          if (positions) {
            switchMasks(positions);
          }
        }

        function startVideo() {
          // start video
          vid.play();
          // start tracking
          ctrack.start(vid);
          trackingStarted = true;
          // start drawing face grid
          drawGridLoop();
        }

        var fd = new faceDeformer();
        var fd2 = new faceDeformer();

        var currentMask = 0;

        // create canvases for all the faces
        var imageCanvases = {};
        var imageCount = 0;
        
        //load masks
        for (var i = 0;i < images.length;i++) {
          loadMask(i);
        }

        var extended_vertices = [
          [0,71,72,0],
          [0,72,1,0],
          [1,72,73,1],
          [1,73,2,1],
          [2,73,74,2],
          [2,74,3,2],
          [3,74,75,3],
          [3,75,4,3],
          [4,75,76,4],
          [4,76,5,4],
          [5,76,77,5],
          [5,77,6,5],
          [6,77,78,6],
          [6,78,7,6],
          [7,78,79,7],
          [7,79,8,7],
          [8,79,80,8],
          [8,80,9,8],
          [9,80,81,9],
          [9,81,10,9],
          [10,81,82,10],
          [10,82,11,10],
          [11,82,83,11],
          [11,83,12,11],
          [12,83,84,12],
          [12,84,13,12],
          [13,84,85,13],
          [13,85,14,13],
          [14,85,86,14],
          [14,86,15,14],
          [15,86,87,15],
          [15,87,16,15],
          [16,87,88,16],
          [16,88,17,16],
          [17,88,89,17],
          [17,89,18,17],
          [18,89,90,18],
          [18,90,22,18],
          [22,90,21,22],
          [21,90,91,21],
          [21,20,91,21],
          [20,91,92,20],
          [20,92,19,20],
          [19,92,93,19],
          [19,93,71,19],
          [19,0,71,19],
          [44,61,56,44],
          [60,61,56,60],
          [60,56,57,60],
          [60,59,57,60],
          [58,59,57,58],
          [58,59,50,58]
        ];

        function drawGridLoop() {
          // get position of face
          positions = ctrack.getCurrentPosition();

          overlayCC.clearRect(0, 0, vid_width, vid_height);
          if (positions) {
            // draw current grid
            ctrack.draw(overlay);
          }
          // check whether mask has converged
          var pn = ctrack.getConvergence();
          if (pn < 0.4) {
            switchMasks(positions);
          } else {
            detectionRequest = requestAnimFrame(drawGridLoop);
          }
        }

        function switchMasks(pos) {
          videocanvas.getContext('2d').drawImage(vid,0,0,videocanvas.width,videocanvas.height);

          // we need to extend the positions with new estimated points in order to get pixels immediately outside mask
          var newMaskPos = masks[images[currentMask].id].slice(0);
          var newFacePos = pos.slice(0);
          var extInd = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,22,21,20,19];
          var newp;
          for (var i = 0;i < 23;i++) {
            newp = [];
            newp[0] = (newMaskPos[extInd[i]][0]*1.3) - (newMaskPos[62][0]*0.3);// short for ((newMaskPos[extInd[i]][0]-newMaskPos[62][0])*1.1)+newMaskPos[62][0]
            newp[1] = (newMaskPos[extInd[i]][1]*1.3) - (newMaskPos[62][1]*0.3);
            newMaskPos.push(newp);
            newp = [];
            newp[0] = (newFacePos[extInd[i]][0]*1.3) - (newFacePos[62][0]*0.3);
            newp[1] = (newFacePos[extInd[i]][1]*1.3) - (newFacePos[62][1]*0.3);
            newFacePos.push(newp);
          }
          // also need to make new vertices incorporating area outside mask
          var newVertices = pModel.path.vertices.concat(extended_vertices);

          // deform the mask we want to use to face form
          fd2.load(imageCanvases[images[currentMask].id], newMaskPos, pModel, newVertices);
          fd2.draw(newFacePos);
          // and copy onto new canvas
          newcanvas.getContext('2d').drawImage(document.getElementById('webgl2'),0,0);

          // create masking
          var tempcoords = positions.slice(0,18);
          tempcoords.push(positions[21]);
          tempcoords.push(positions[20]);
          tempcoords.push(positions[19]);
          createMasking(maskcanvas, tempcoords);

          // do poisson blending
          Poisson.load(newcanvas, videocanvas, maskcanvas, function() {
            var result = Poisson.blend(30, 0, 0);
            // render to canvas
            newcanvas.getContext('2d').putImageData(result, 0, 0);
            // get mask

            var maskname = Object.keys(masks)[currentMask];
            fd.load(newcanvas, pos, pModel);
            animationRequest = requestAnimFrame(drawMaskLoop);
          });
        }

        function drawMaskLoop() {
          animationRequest = requestAnimFrame(drawMaskLoop);
          // get position of face
          positions = ctrack.getCurrentPosition();

          overlayCC.clearRect(0, 0, vid_width, vid_height);
          if (positions) {
            // draw mask on top of face
            fd.draw(positions);
          }
        }

        function createMasking(canvas, modelpoints) {
          // fill canvas with black
          var cc = canvas.getContext('2d');
          cc.fillStyle="#000000";
          cc.fillRect(0,0,canvas.width, canvas.height);
          cc.beginPath();
          cc.moveTo(modelpoints[0][0], modelpoints[0][1]);
          for (var i = 1;i < modelpoints.length;i++) {
            cc.lineTo(modelpoints[i][0], modelpoints[i][1]);
          }
          cc.lineTo(modelpoints[0][0], modelpoints[0][1]);
          cc.closePath();
          cc.fillStyle="#ffffff";
          cc.fill();
        }

        /*********** Code for stats **********/

        stats = new Stats();
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.top = '0px';
        document.getElementById('container').appendChild( stats.domElement );

        document.addEventListener("clmtrackrIteration", function(event) {
          stats.update();
        }, false);

      </script>

      <p>Printing coordinates of 70 points in facial features:</p>
      <p id="positions"></p>
      <script>
        var videoInput = document.getElementById('videoel');

        var ctracker = new clm.tracker();
        ctracker.init();
        ctracker.start(videoInput);

        function positionLoop() {
          requestAnimFrame(positionLoop);
          var positions = ctracker.getCurrentPosition();
          // do something with the positions ...
          // print the positions
          var positionString = "";
          if (positions) {
            for (var p = 0;p < 70;p++) {
              positionString += "featurepoint "+p+" : ["+positions[p][0].toFixed(2)+","+positions[p][1].toFixed(2)+"]<br/>";
            }
            document.getElementById('positions').innerHTML = positionString;
          }
        }
        positionLoop();

        var canvasInput = document.getElementById('canvas');
        var cc = canvasInput.getContext('2d');
        function drawLoop() {
          requestAnimFrame(drawLoop);
          cc.clearRect(0, 0, canvasInput.width, canvasInput.height);
          ctracker.draw(canvasInput);
        }
        drawLoop();
      </script>
    </div>
  </body>
</html>

