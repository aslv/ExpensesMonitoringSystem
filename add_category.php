<?php
echo generateHeader('Добавяне на категория разход');
?>
<form method="POST" action="expense.php">
    <div>
        Моля, въведете наименованието на категорията, която искате да добавите:
        <input type="text" required name="category" placeholder="min 4 symbols" maxlength="50" />
        <span class="tip">* Минимум 4 символа</span>
    </div>
    <div>
        <input type="submit" value="Добави категория" />
    </div>
    <input type="hidden" name="operation" value="add_category" />
</form>
