    <form method="POST" action="expense.php">
    <?php if ($hidden == 'edit_expense'): ?>
        <?php if (file_exists('records')):  ?>
            <?php $records = file('records'); ?>
            <div>
                Моля, изберете кой разход желаете да редактирате:
                <select required name="expenses">;
                <?php
                foreach($records as $key => $record)
                {
                    $expense = explode($delim, $record);
                    echo '<option value="' . $key . '">' . $expense[0] . '</option>';
                }
                ?>
                </select>
            </div>
        <?php else: ?>
            <!-- file error-->
        <?php endif; ?> 
    <?php endif; ?>
        <div>
            Наименование:<input type="text" required name="name" />
        </div>
        <div>
            Цена:<input type="number" required step="0.01" name="price" />
        </div>
        <div>
            Дата:<input type="date" required name="date" value="<?= date($GLOBALS['formatDate']); ?>" />
        </div>
        <div>
            Категория:
            <select required name="category">
            <?php
            foreach($GLOBALS['groups'] as $key => $category)
            {
                echo '<option value="' . $key . '">' . $category . '</option>';
            }
            ?>
            </select>
        </div>
        <div>
            <input type="submit" value="<?php if($hidden == 'add_expense')echo 'Добави'; else echo 'Редактирай'; ?>" />
        </div>
        <input type="hidden" name="operation" value="<?= $hidden; ?>" />
    </form>