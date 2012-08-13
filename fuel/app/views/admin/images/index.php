<h2>Listing Images</h2>
<br>
<?php if ($images): ?>
    <table class="table table-striped table-bordered">
        <thead>
    	<tr>
    	    <th>Image</th>
    	    <th>Movie</th>
    	    <th>Height</th>
    	    <th>Width</th>
    	    <th>Type</th>
    	    <th></th>
    	</tr>
        </thead>
        <tbody>
	    <?php foreach ($images as $image): ?>		
		<tr>
		    <td><img src="<?php echo $image->get_thumb_url(92,138); ?>" onmouseout="hiddenPic();" onmousemove="showPic(this.src, '<?php echo $image->get_type(); ?>');" /></td>
		    <td><?php echo ($image->movie == null) ? 'None' : $image->movie->title; ?></td>		
		    <td><?php echo $image->height; ?></td>
		    <td><?php echo $image->width; ?></td>
		    <td><?php echo ucfirst($image->get_type()); ?></td>
		    <td>
			<?php echo Html::anchor('admin/images/view/' . $image->id, 'View'); ?> |
			<?php echo Html::anchor('admin/images/edit/' . $image->id, 'Edit'); ?> |
			<?php echo Html::anchor('admin/images/delete/' . $image->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

		    </td>
		</tr>
	    <?php endforeach; ?>	
	</tbody>
    </table>

<?php else: ?>
    <p>No Images.</p>

<?php endif; ?><p>
    <?php echo Html::anchor('admin/images/create', 'Add new Image', array('class' => 'btn btn-success')); ?>
<?php echo \Fuel\Core\Pagination::create_links(); ?>
</p>

<?php // TODO: Move this its own file ?>
<script>
    function showPic(sUrl, sType)
    {
	var x,y,h,w;
	x = event.pageX + 10;
	y = event.pageY + 10;
	h = 100;
	w = 200;
	if (sType == 'poster')
	{
		h = 278;
		w = 185;
	}
	document.getElementById("Layer1").style.left = x+"px";
	document.getElementById("Layer1").style.top = y+"px";
	if (document.getElementById("Layer1").innerHTML != "<img height=500 width=336 src=\"" + sUrl.replace("-92x138","-" + w + "x" + h) + "\">") 
	{
	    document.getElementById("Layer1").innerHTML = "<img height=500 width=336 src=\"" + sUrl.replace("-92x138","-" + w + "x" + h) + "\">";
	    document.getElementById("Layer1").style.display = "block";
	}
    }
    function hiddenPic(){
	document.getElementById("Layer1").innerHTML = "";
	document.getElementById("Layer1").style.display = "none";
    }
</script>
<div id="Layer1" style="display:none;position:absolute;z-index:1;"></div>
