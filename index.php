<?php
$pageTitle = '';
include 'includes/header.php';
?>

<div id="site" class="container_12">
    <header>
        <h2>
            <a id="top"><?= $indexHeading;?></a>
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
        </header><!--
        <form>
            <div>
                <select>
                    Филтър по категория:
                    <option></option>
                </select>
            </div>
            <div>
                <select>
                    Филтър по дата:
                    <option></option>
                </select>
            </div>
            <div>
                <input type="submit" value="Покажи"/>
            </div>
        </form>-->
        <br>
        <table>
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
                    $totalSum += (float)$columns[1];
                    echo '<tr>
                               <td>' . $columns[0] . '</td>
                               <td>' . $columns[1] . '</td>
                               <td>' . $columns[2] . '</td>
                               <td>' . $columns[3] . '</td>
                           </tr>';
                }
                echo '<tr><th>ОБЩО</th><th colspan="3">' . $totalSum . '</th></tr>';
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