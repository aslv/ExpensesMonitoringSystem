<?php
echo generateHeader('Добавяне на категория разход');
?>
<form method="POST" action="expense.php">
    <div>
        Моля, въведете наименованието на категорията, която искате да добавите:
        <input type="text" required name="category" />
    </div>
    <div>
        <input type="submit" name="Добави категория" />
    </div>
    <input type="hidden" name="operation" value="add_category" />
</form>
