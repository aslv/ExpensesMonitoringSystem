<?php
mb_internal_encoding('UTF-8');
$pageTitle = '';
include 'includes/header.php';

if ($_POST)
{
    function validateDate($date)
    {
        $d = DateTime::createFromFormat($GLOBALS['formatDate'], $date);
        return $d && $d->format($GLOBALS['formatDate']) == $date;
    }
    
    if ($_POST['operation'] == 'add_expense')
    {
        // normalization
        $name = trim($_POST['name']);
        $name = str_replace($delim, '', $name);
        $name = htmlspecialchars($name, ENT_QUOTES | ENT_HTML5);
        
        $price = (float)$_POST['price'];
        if(!$_POST['date'])$date = date($GLOBALS['formatDate']);
        else $date = $_POST['date'];/*
        $date = trim($_POST['date']);
        $date = str_replace($delim, '', $date);
        */
        $category = (int)$_POST['category'];
        
        // validation
        $error = false;
        $errorLog = '';
        if (mb_strlen($name) < 4)
        {
            $errorLog .= 'Наименованието на разхода е прекалено късо!<br>';
            $error = true;
        }
        if ($price <= 0)
        {
            $errorLog .= 'Цената на разхода трябва да е положително число!<br>';
            $error = true;
        }/*
        if (!validateDate($date))
        {
            echo "'$date'<br>";
            $errorLog .= 'Форматът на датата не е правилен и/или датата не е валидна!<br>';
            $error = true;
        }*/
        if (!array_key_exists($category, $groups))
        {
            $errorLog .= 'Няма такава категория разходи!<br>';
            $error = true;
        }
        
        if (!$error)
        {
            $record = $name . $delim . $price . $delim . $date . $delim . $category . "\n";
            if (file_put_contents('records', $record, FILE_APPEND))
            {
                echo 'Записът бе успешно добавен!<br>';
            }
            else
            {
                echo 'Записът не може да се запише! Моля, опитайте по-късно!<br>';
            }
        }
        else
        {
            echo 'Възникнаха следните грешки:<br>' . $errorLog;
        }
        
    } // end add_expense
    elseif ($_POST['operation'] == 'edit_expense')
    {
        // normalization
        $name = trim($_POST['name']);
        $name = str_replace($delim, '', $name);
        $name = htmlspecialchars($name, ENT_QUOTES | ENT_HTML5);
        
        $price = (float)$_POST['price'];
        
        $date=$_POST['date'];/*
        $date = trim($_POST['date']);
        $date = str_replace($delim, '', $date);
        */
        $category = (int)$_POST['category'];
        
        $selectedRecord = (int)$_POST['expenses'];
        
        // validation
        $error = false;
        $errorLog = '';
        if (mb_strlen($name) < 4)
        {
            $errorLog .= 'Наименованието на разхода е прекалено късо!<br>';
            $error = true;
        }
        if ($price <= 0)
        {
            $errorLog .= 'Цената на разхода трябва да е положително число!<br>';
            $error = true;
        }/*
        if (!validateDate($date))
        {
            $errorLog .= 'Форматът на датата не е правилен и/или дата не е валидна!<br>';
            $error = true;
        }*/
        if (!array_key_exists($category, $groups))
        {
            $errorLog .= 'Няма такава категория разходи!<br>';
            $error = true;
        }
        if(file_exists('records'))
        {
            $result = file('records');
            if($selectedRecord < 0 || $selectedRecord >= count($result))
            {
                $errorLog .= "Записът, който искате да редактирате, е невалиден!<br>";
                $error = true;
            }
        }
        else
        {
            $errorLog .= "Системата не може да редактира записа! Моля, опитатйте по-късно!<br>";
            $error = true;
        }
        
        if (!$error)
        {
            $record = $name . $delim . $price . $delim . $date . $delim . $category . "\n";
            $result[$selectedRecord] = $record;
            if (file_put_contents('records', $result))
            {
                echo 'Записът бе успешно редактиран!<br>';
            }
            else
            {
                echo 'Записът не може да се редактира! Моля, опитайте по-късно!<br>';
            }
        }
        else
        {
            echo 'Възникнаха следните грешки:<br>' . $errorLog;
        }
    } // end edit_expense
    elseif ($_POST['operation'] == 'add_category')
    {
        // normalization
        $category = trim($_POST['category']);
        $category = str_replace($delim, '', $category);
        $category = htmlspecialchars($category, ENT_QUOTES | ENT_HTML5);
        
        // validation
        $error = false;
        if (mb_strlen($category) < 4)
        {
            $errorLog = 'Наименованието на категорията е прекалено късо!<br>';
            $error = true;
        }
        if (!$error)
        {
            $category .= "\n";
            if (file_put_contents('includes/categories', $category, FILE_APPEND))
            {
                echo 'Категорията бе добавена успешно!<br>';
            }
            else
            {
                echo 'Категорията не може да се добеви!<br>Моля, опитайте по-късно!';
            }
        }
        else
        {
            echo 'Възникнаха следните грешки:<br>' . $errorLog;
        }
    } // end add_category
} // end if($_POST)
?>

<div id="site" class="container_12">
    <header>
        <h2>
            <a id="top"><?= $indexHeading; ?></a>
        </h2>
    </header>
    
    <nav class="grid_3">
        <ul>
            <li>
                <a href="index.php">Обратно към списъка</a>
            </li>
            <?php include 'nav.php'; ?>
        </ul>
    </nav>

    <section class="grid_9">
<?php

function generateHeader($header)
{
    return '<header>' . $header . '</header>' . "\n";
}

/* All the following cases will lead to expense appending */
if (!$_GET || // empty _GET
    //!array_key_exists('action', $_GET) || // no 'action' key
    $_GET['action'] == 'append' || // append operation
    ($_GET['action'] != 'edit' && $_GET['action'] != 'add_category')) // invalid action
{
    include 'add_expense.php';
}
elseif ($_GET['action'] == 'edit')
{
    include 'edit_expense.php';
}
elseif ($_GET['action'] == 'add_category')
{
    include 'add_category.php';
}
else
{
    echo 'Здравейте!<br>Не сте избрали никаква задача.<br>Моля, изберете от менюто вляво!';
}
?>
    <footer>
        <h5><?= $author; ?></h5>
    </footer>
</div>

<?php
include 'includes/footer.php';
?>