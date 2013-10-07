<nav>
	<ul>
	<?php 
		$controller = $this->params['controller'];

		if ($controller == 'pages' && $this->params['pass'][0] == 'home') {
			echo "<li>".$this->Html->link('Start', '/pages/home', array('class' => 'active'))."</li>";
		} else {
			echo "<li>".$this->Html->link('Start', '/pages/home')."</li>";
		}

		if ($controller == 'pages' && $this->params['pass'][0] == 'biography') {
			echo "<li>".$this->Html->link('Biografie', '/pages/biography', array('class' => 'active'))."</li>";
		} else {
			echo "<li>".$this->Html->link('Biografie', '/pages/biography')."</li>";
		}

		if ($controller == "therapies") {
			echo "<li>".$this->Html->link('Heilverfahren', array('controller' => 'therapies', 'action' => 'index'), array('class' => 'active'))."</li>";
			echo "<ul>";

			if ($this->action == 'classic') {
				echo "<li>".$this->Html->link('Klassische Homöopathie', array('action' => 'classic'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Klassische Homöopathie', array('action' => 'classic'))."</li>";
			}

			if ($this->action == 'children') {
				echo "<li>".$this->Html->link('Kinder und Homöopathie', array('action' => 'children'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Kinder und Homöopathie', array('action' => 'children'))."</li>";
			}

			if ($this->action == 'psychotherapy'||$this->action == 'psychotherapy_rogers') {
				echo "<li>".$this->Html->link('Psychotherapie', array('action' => 'psychotherapy'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Psychotherapie', array('action' => 'psychotherapy'))."</li>";
			}

			if ($this->action == 'medical') {
				echo "<li>".$this->Html->link('Mediz. Heilhypnose', array('action' => 'medical'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Mediz. Heilhypnose', array('action' => 'medical'))."</li>";
			}
			echo "</ul>";

		} else {
			echo "<li>".$this->Html->link('Heilverfahren', array('controller' => 'therapies', 'action' => 'index'))."</li>";
		}


		if ($controller == "practice") {
			echo "<li>".$this->Html->link('Praxis', array('controller' => 'practice', 'action' => 'index'), array('class' => 'active'))."</li>";
			echo "<ul>";

			if ($this->action == 'pics') {
				echo "<li>".$this->Html->link('Bilder', array('action' => 'pics'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Bilder', array('action' => 'pics'))."</li>";
			}

			if ($this->action == 'consultation') {
				echo "<li>".$this->Html->link('Sprechzeiten', array('action' => 'consultation'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Sprechzeiten', array('action' => 'consultation'))."</li>";
			}

			if ($this->action == 'treatment') {
				echo "<li>".$this->Html->link('Behandlung', array('action' => 'treatment'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Behandlung', array('action' => 'treatment'))."</li>";
			}

			if ($this->action == 'costs') {
				echo "<li>".$this->Html->link('Kosten', array('action' => 'costs'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Kosten', array('action' => 'costs'))."</li>";
			}

			if ($this->action == 'tariffs') {
				echo "<li>".$this->Html->link('Gebührenordnung', array('action' => 'tariffs'), array('class' => 'active'))."</li>";
			} else {
				echo "<li>".$this->Html->link('Gebührenordnung', array('action' => 'tariffs'))."</li>";
			}

			echo "</ul>";
		} else {
			echo "<li>".$this->Html->link('Praxis', array('controller' => 'practice', 'action' => 'index'))."</li>";
		}

		if ($controller == 'pages' && $this->params['pass'][0] == 'contact') {
			echo "<li>".$this->Html->link('Kontakt', '/pages/contact', array('class' => 'active'))."</li>";
		} else {
			echo "<li>".$this->Html->link('Kontakt', '/pages/contact')."</li>";
		}

		if ($controller == 'pages' && $this->params['pass'][0] == 'drive') {
			echo "<li>".$this->Html->link('Anfahrt', '/pages/drive', array('class' => 'active'))."</li>";
		} else {
			echo "<li>".$this->Html->link('Anfahrt', '/pages/drive')."</li>";
		}

		if ($controller == 'pages' && $this->params['pass'][0] == 'impressum') {
			echo "<li>".$this->Html->link('Impressum', '/pages/impressum', array('class' => 'active'))."</li>";
		} else {
			echo "<li>".$this->Html->link('Impressum', '/pages/impressum')."</li>";
		}

		if ($controller == 'pages' && $this->params['pass'][0] == 'links') {
			echo "<li>".$this->Html->link('Links', '/pages/links', array('class' => 'active'))."</li>";
		} else {
			echo "<li>".$this->Html->link('Links', '/pages/links')."</li>";
		}
	?>
	</ul>

	<figure>
		<?php 
			echo $this->Html->image('logo_160.png', array('alt' => 'logo', 'width' => '158px'));
		?>
		<figcaption>Heilpraktikerin für Kinder und Erwachsene</figcaption>
	</figure>
</nav>