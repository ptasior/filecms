<h1>Menu</h1>

<?php function print_menu($root) {?>
<ul>
	<span><?php echo $root['name'];?></span>
	<?php foreach($root['list'] as $l):?>
		<?php if(is_array($l)):?>
			<?php print_menu($l);?>
			<?php continue;?>
		<?php endif;?>
		<li><a href="<?=$root['path'].'/'.$l;?>"><?php echo $l;?></a></li>
	<?php endforeach;?>
</ul>
<?php }?>

<?php print_menu($params['tree']);?>

