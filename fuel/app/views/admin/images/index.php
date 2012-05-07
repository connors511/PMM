<h2>Listing Images</h2>
<br>
<?php if ($images): ?>
    <table class="zebra-striped">
        <thead>
    	<tr>
    	    <th>Image</th>
    	    <th>Movie</th>
    	    <th>Height</th>
    	    <th>Width</th>
    	    <th></th>
    	</tr>
        </thead>
        <tbody>
	    <?php foreach ($images as $image): ?>		<tr>
		    <?php // TODO: Fix this url.. ?>
		    <td><img src="<?php echo Uri::base(false) . $image->get_thumb_url(); ?>" onmouseout="hiddenPic();" onmousemove="showPic(this.src);" /></td>
		    <td><?php echo ($image->movie == null) ? 'None' : $image->movie->title; ?></td>		
		    <td><?php echo $image->height; ?></td>
		    <td><?php echo $image->width; ?></td>
		    <td>
			<?php echo Html::anchor('admin/images/view/' . $image->id, 'View'); ?> |
			<?php echo Html::anchor('admin/images/edit/' . $image->id, 'Edit'); ?> |
			<?php echo Html::anchor('admin/images/delete/' . $image->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

		    </td>
		</tr>
	    <?php endforeach; ?>	</tbody>
    </table>

<?php else: ?>
    <p>No Images.</p>

<?php endif; ?><p>
    <?php echo Html::anchor('admin/images/create', 'Add new Image', array('class' => 'btn success')); ?>
<ul class="pager">
	<li class="previous">
		<?php echo \Fuel\Core\Pagination::prev_link('Previous'); ?>
	</li>
	<li class="next">
		<?php echo \Fuel\Core\Pagination::next_link('Next'); ?>
	</li>
</ul>
</p>

<?php // TODO: Move this its own file ?>
<script>
    function showPic(sUrl)
    {
	var x,y;
	x = event.pageX + 10;
	y = event.pageY + 10;
	document.getElementById("Layer1").style.left = x+"px";
	document.getElementById("Layer1").style.top = y+"px";
	if (document.getElementById("Layer1").innerHTML != "<img height=200 width=400 src=\"" + sUrl.replace("_thumb","") + "\">") 
	{
	    document.getElementById("Layer1").innerHTML = "<img height=200 width=400 src=\"" + sUrl.replace("_thumb","") + "\">";
	    document.getElementById("Layer1").style.display = "block";
	}
    }
    function hiddenPic(){
	document.getElementById("Layer1").innerHTML = "";
	document.getElementById("Layer1").style.display = "none";
    }
</script>
<div id="Layer1" style="display:none;position:absolute;z-index:1;"></div>
