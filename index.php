<?php
$pageTitle = 'Списък';
include 'includes/header.php';
?>

<div id="site" class="container_12">
    <header>
        <h2>
            <a id="top"><?= $heading;?></a>
        </h2>
    </header>
    
    <nav class="grid_3">
        <ul>
            <?php include 'nav.php'; ?>
        </ul>
    </nav>
    
    <section class="grid_9">
        <header>
            Налични разходи:
        </header>
        <form method="GET" action="">
            <div>
            	Филтър по категория:
                <select name="category[]" size="3" multiple>
                	<?php
                	if (file_exists('includes/categories'))
                	{
                		$categories = file('includes/categories');
                		echo '<option selected value="all">Всички</option>';
                		foreach ($categories as $key => $category)
                		{
                			echo '<option value="' . $key . '">' . $category . '</option>';
                		}
                	}
                	?>
                </select>
            </div>
            <div>
            	Филтър по дата:
                <select name="date[]" size="3" multiple>
                    <?php
                    if (file_exists('records'))
                    {
                    	$records = file('records');
                    	foreach ($records as $record)
                    	{
                    		$cells = explode($delim, $record);
                    		$dates[] = $cells[2];
                    	}
                    	$dates = array_unique($dates);
                    	echo '<option selected value="all">Всички</option>';
                    	foreach ($dates as $date)
                    	{
                    		echo '<option value="' . $date . '">' . $date . '</option>';
                    	}
                    }
                    ?>
                </select>
            </div>
            <div>
                <input type="submit" value="Покажи"/>
            </div>
        </form>
        <br>
        <table class="index">
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Дата</th>
                <th>Категория</th>
            </tr>
            <?php
            if (file_exists('records'))
            {
                $totalSum = 0;
                $result = file('records');
                foreach($result as $record)
                {
                    $columns = explode($delim, $record);
                    if ($_GET && ($_GET['category'] || $_GET['date'])) // if filters are set
                    {
                    	if ($_GET['category']) // if category filter is on
                    	{
                    		if ($_GET['category'][0] == 'all')
                    		{
                    			$categoryCheck = true;
                    		}
                    		else
                    		{
                    			$categoryCheck = false;
                    			foreach ($_GET['category'] as $category)
                    			{
                    				if ($category . "\n" == $columns[3])
                    				{
                    					$categoryCheck = true;
                    					break;
                    				}
                    			}
                    		}
                    	}
                    	if ($_GET['date']) // if date filter is on
                    	{
                    		if ($_GET['date'][0] == 'all')
                    		{
                    			$dateCheck = true;
                    		}
                    		else
                    		{
                    			$dateCheck = false;
                    			foreach ($_GET['date'] as $date)
                    			{
                    				if ($date == $columns[2])
                    				{
                    					$dateCheck = true;
                    					break;
                    				}
                    			}
                    		}
                    	}
                    	if ($categoryCheck && $dateCheck)
                    	{
                    		$totalSum += (float)$columns[1];
                    		echo '<tr>
                               	   <td>' . $columns[0] . '</td>
                                   <td>' . $columns[1] . '</td>
                                   <td>' . $columns[2] . '</td>
                                   <td>' . $columns[3] . '</td>
                                </tr>';
                    	}
                    }
                    else
                    {
                    	$totalSum += (float)$columns[1];
                    	echo '<tr>
                               <td>' . $columns[0] . '</td>
                               <td>' . $columns[1] . '</td>
                               <td>' . $columns[2] . '</td>
                               <td>' . $columns[3] . '</td>
                            </tr>';
                    }
                }
                if ($totalSum == 0)
                {
                	echo '<tr><td colspan="4">Съжаляваме, но нямя записи, отговарящи на посочените от Вас критерии!</td></tr>';
                }
                else
                {
                	echo '<tr><th>ОБЩО</th><th colspan="3">' . $totalSum . '</th></tr>';
                }
            }
            else
            {
                echo '<tr><th colspan="4">Четенето на записите пропадна!</th></tr>';
            }
            ?>
        </table>
        <br>
    </section>
    
    <footer>
        <h5><?= $author;?></h5>
    </footer>
</div>

<?php
include 'includes/footer.php';
?>