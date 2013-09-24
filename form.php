    <form method="POST" action="expense.php">
    <table class="form">
    	<?php if ($hidden == 'edit_expense'): ?>
        	<?php if (file_exists('records')):  ?>
           		<?php $records = file('records'); ?>
            	<tr>
            		<td>
                		Моля, изберете кой разход желаете да редактирате:
                	</td>
                	<td>
                		<select required name="expenses">;
                		<?php
                		foreach($records as $key => $record)
                		{
                	    	$expense = explode($delim, $record);
                    		echo '<option value="' . $key . '">' . $expense[0] . '</option>';
                		}
                		?>
                		</select>
                	</td>
            	</tr>
        	<?php else: ?>
        		<tr>
        			<td colspan="2">
            			<div class="red">
            				Четенето на списъка с категории пропадна!<br>Моля, опитайте по-късно!
            			</div>
            		</td>
            	</tr>
        	<?php endif; ?>
    	<?php endif; ?>
        	<tr>
            	<td>Наименование:</td>
            	<td><input type="text" required name="name" placeholder="min 4 symbols" /></td>
        	</tr>
        	<tr>
            	<td>Цена:</td>
            	<td><input type="number" required step="0.01" min="0.01" name="price" placeholder="min 0.01" /></td>
        	</tr>
        	<tr>
            	<td>Дата:</td>
            	<td><input type="date" required name="date" value="<?= date($GLOBALS['formatDate']); ?>" placeholder="yyyy-mm-dd" /></td>
        	</tr>
        	<tr>
            	<td>Категория:</td>
            	<td>
            		<select required name="category">
            		<?php
            		foreach($GLOBALS['groups'] as $key => $category)
            		{
                		echo '<option value="' . $key . '">' . $category . '</option>';
            		}
            		?>
            	   	</select>
            	</td>
        	</tr>
        	<tr>
        		<td colspan="2">
            		<input type="submit" value="<?php if($hidden == 'add_expense')echo 'Добави'; else echo 'Редактирай'; ?>" />
            	</td>
        	</tr>
        	<input type="hidden" name="operation" value="<?= $hidden; ?>" />
        </table>
    </form>