$(function(){
	$('#addpost').click(function(event) {
		$('#request').append('<div class="form-group"><div class="col-sm-4"><input type="text" name="key[]" class="form-control" placeholder="键值"></div><div class="col-sm-8"><input type="text"  name="value[]"  class="form-control" placeholder="值，数组(以,隔开)：1,2,3,4"></div></div>');
	});
	$('#addfile').click(function(event) {
		$('#filerequest').append('<div class="form-group"><div class="col-sm-4"><button  style="width:100%;" type="button" class="btn btn-info">上传文件：</button></div><div class="col-sm-4"><input type="file"  name="Filedata"  class="form-control"></div><div class="col-sm-4"><input type="text"  name="filename"  placeholder="键值，默认Filedata"  class="form-control"></div></div>');
	});
	$('#apiHis li a').click(function(event) {
		var hid = $(this).attr('val');
		$.post(url+'/getHistory', { hid:hid},
		   function(data){
		     $('#param').html(data);
		});
	});
})