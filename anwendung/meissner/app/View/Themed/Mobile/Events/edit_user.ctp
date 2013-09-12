<div data-role="header">
	<a href="#" data-rel="back" data-role="button" data-inline="true" data-icon="arrow-l">Back</a>
	<h1>Edit columns for user</h1>
</div>
<div data-role="content">
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
				foreach ($fields as $field):
					$name = $field['event_columns']['name'];
					if (!isset($alreadyTypedIn[$name]))
						$value = "";
					else
						$value = $alreadyTypedIn[$name];
				?>
					<tr>
						<td>
							<?php echo $name; ?>
						</td> 
						<td>
							<?php echo $this->Form->input('post'.$i, array('label' => false, 'value' => $value)); ?>
						</td>
					</tr>
			<?php
				$i++;
				endforeach;
				unset($columns); 
			?>
			</table>
			<?php echo $this->Form->end('Save Changes'); ?>
		</p>
	</article>
</div>