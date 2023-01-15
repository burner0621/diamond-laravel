<x-app-layout page-title="Chat">
  
<style>

  #chat_area
  {
    min-height: 500px;
    /*overflow-y: scroll*/;
  }
  
  #chat_history
  {
    min-height: 500px; 
    max-height: 500px; 
    overflow-y: auto; 
    margin-bottom:16px; 
    background-color: #ece5dd;
    padding: 16px;
  }
  
  #user_list
  {
    min-height: 500px; 
    max-height: 500px; 
    overflow-y: auto;
  }
  </style>
<section class="bg-white pb-4">
<div class="container">

<div class="row">
	<div class="col-md-12" style="height: 80px"></div>
	<div class="col-sm-4 col-lg-3">
		<div class="card">
			<div class="card-header"><b>Connected User</b></div>
			<div class="card-body" id="user_list">
				
			</div>
		</div>
	</div>
	<div class="col-sm-8 col-lg-9">
		<div class="card">
			<div class="card-header">
				<div class="col-md-12 row">
					<div class="col col-md-6" id="chat_header"><b>Chat Area</b></div>
					<div class="col col-md-6" id="close_chat_area"></div>
				</div>
			</div>
			<div class="card-body" id="chat_area">
				
			</div>
		</div>
	</div>
</div>

</section>
</div>

<script>

</script>
</x-app-layout>
