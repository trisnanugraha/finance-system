<?php
$no = 1;
foreach ($dataLog as $log) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $log->username; ?></td>
    <td><?php switch ($log->typeLog) {
          case 0:
            echo 'Login';
          break;
          case 1:
            echo 'Logout';
          break;
          case 2:
            echo 'Add';
          break;
          case 3:
            echo 'Edit';
          break;
          case 4:
            echo 'Delete';
          break;
          case 5:
            echo 'Export';
          break;
          case 6:
            echo 'Import';
          break;
          case 7:
            echo 'Etc';
          break;
          default:
        break;
    }
        ?>
    </td>
    <td><?php echo $log->descLog; ?></td>
    <td><?php echo $log->itemLog; ?></td>
    <td><?php echo $log->timeLog; ?></td>
    <td><?php echo $log->ip; ?></td>
  </tr>
<?php
  $no++;
}
?>