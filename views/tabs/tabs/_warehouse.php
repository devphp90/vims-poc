<style type="text/css">
	.warehouse-group input
	{

	}
	.warehouse-group label
	{
		display: inline;
		margin-right:20px;
		margin-left:10px;
		
	}
	#warehouse-section label
	{
		margin-left:40px;
	}
	.warehouse-group a
	{
		margin-left:10px;
		
	}
</style>
<script>
$(function(){
	$('.update-warehouse').live('click',function(){
		var ware_id = $(this).attr(':ware_id');
		var name = $(this).parent().find(".update-name").val();
		var state = $(this).parent().find(".update-state").val();
		var zip_code = $(this).parent().find(".update-zipcode").val();
		$this = $(this);
		console.log(name);
		
//		$this = $(this).parent.html();
		

		$.ajax({
			url: '<?php echo $this->createUrl('/tabs/updatewarehouse')?>',
			data:{
				ware_id: ware_id,
				name: name,
				state: state,
				zip_code: zip_code,
			},
			beforeSend:function(){
				$this.html('Warehouse saving....');
				
			},
			complete:function(){
				$this.html('Save');
				
			},
		});

	});
	
	$('.delete-warehouse').live('click',function(){
		var ware_id = $(this).attr(':ware_id');

		$this = $(this);
	
		

		$.ajax({
			url: '<?php echo $this->createUrl('/tabs/deletewarehouse')?>',
			data:{
				ware_id: ware_id,
			},
			beforeSend:function(){
				$this.html('Warehouse Deleting....');
				
			},
			success:function(){

				$this.parent().remove()
				
			},
		});

	});
	
	
	

	
});
</script>
<div class="row well">
	<?php
		$i = 1;
		foreach($model->tabsWarehouses as $id=>$warehouse){
			if($warehouse->warehouse == null){
				$warehouse->delete();
				continue;
			}
	?>
		<div class="control-group warehouse-group">

			<label>Name</label>
			<input class="span2 update-name" type="text" maxlength="50" value="<?php echo $warehouse->warehouse->name?>" />
			
			<label>State </label>
			<input class="span2 update-state" type="text" maxlength="50" value="<?php echo $warehouse->warehouse->state?>" />
			
			<label>Zipcode </label>
			<input class="span2 update-zipcode" type="text" maxlength="50" value="<?php echo $warehouse->warehouse->zip_code?>" />
			
			<a class="update update-warehouse" :ware_id="<?php echo $warehouse->warehouse->id?>" href="#"><i class="icon-arrow-down"></i>Save</a>
			<?php
			if($i !=1){
			?>	
			<a class="update delete-warehouse" :ware_id="<?php echo $warehouse->warehouse->id?>" href="#"><i class="icon-trash"></i>Delete</a>	
			<?php	
			}
			?>
		</div>
	<?php	
		$i++;
		}
	?>
	<div class="row" id="warehouse-section">
		
	</div>
</div>
<div class="control-group warehouse-group">

	<label>Name</label>
	<input class="span2" placeholder="Warehouse name" id="warehouse_name" name="Warehouse[name]" type="text" maxlength="50" value="" />
	
	<label>State </label>
	<input class="span2" placeholder="Warehouse State" id="warehouse_state" name="Warehouse[state]" type="text" maxlength="50" value="" />

	
	<label>Zipcode </label>
	<input class="span2" placeholder="Warehouse Zipcode" id="warehouse_zipcode" name="Warehouse[zipcode]" type="text" maxlength="50" value="" />
	
	<?php echo CHtml::ajaxLink('<i class="icon-plus"></i>Add Warehouse',array('/tabs/warehouseadd'),array(
					'data'=>array(
						'name'=>'js:$(\'#warehouse_name\').val()',
						'state'=>'js:$(\'#warehouse_state\').val()',
						'zipcode'=>'js:$(\'#warehouse_zipcode\').val()',
						'tabs_id'=>$model->id,
					),
					'class'=>'add-warehouse',
					'replace'=>'#warehouse-section',
					'beforeSend'=>'function(){$(\'#warehouse-section\').html(\'<label>Adding......</label>\')}',
					'complete'=>'function(){$(\'#warehouse_name\').val(\'\');$(\'#warehouse_state\').val(\'\');$(\'#warehouse_zipcode\').val(\'\')}',
		));?>
</div>