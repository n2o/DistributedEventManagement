<article>
	<h1>Set event specific columns for user</h1>
	<p>
		<table>
			<thead>
				<th>Field</th>
				<th>Value</th>
			</thead>
		<?php 
			$i = 0;
			echo $this->Form->create('inputColumn');
			foreach ($columns as $column): ?> 
				<tr>
					<td>
						<?php echo $column['field']; ?>
					</td> 
					<td>
						<?php echo $this->Form->input('post'.$i++, array('label' => '')); ?>
					</td>
				</tr>
		<?php
			endforeach;
			unset($columns); 
		?>
		</table>
		<?php echo $this->Form->end('Save Changes'); ?>
	</p>
</article>