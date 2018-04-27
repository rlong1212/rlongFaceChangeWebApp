@extends('layouts.app')

@section('content')
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/clmtrackr.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Manipulate</div>

                
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-8 col-md-offset-2">
    		<video id="inputVideo" width="748" height="600" style="border:1px solid black" autoplay loop>
 				<source src="http://192.168.1.8:8160"/>
			</video>
			<!-- <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" version="VideoLAN.VLCPlugin.2"  width="100%"  height="100%" id="vlc" loop="yes" autoplay="yes" target="http://192.168.1.8:8160"></embed> -->
			<script type="text/javascript">
  				var videoInput = document.getElementById('inputVideo');
  
  				var ctracker = new clm.tracker();
  				ctracker.init();
  				ctracker.start(videoInput);
			</script>
    	</div>
    </div>
</div>
@endsection

