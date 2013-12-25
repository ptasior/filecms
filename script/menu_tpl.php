<h1>Menu</h1>

<?php function print_menu($root) {?>
<ul>
	<li>
		<a href="<?=$root['path']?>"><?=$root['name']?></a>
	</li>
	<?php foreach($root['list'] as $l):?>
		<?php if(is_array($l)):?>
			<?php print_menu($l)?>
		<?php else:?>
			<li><a href="<?=$root['path'].'/'.$l?>"><?=$l?></a></li>
		<?php endif;?>
	<?php endforeach;?>
</ul>
<?php }?>

<?php print_menu($params['tree']);?>

