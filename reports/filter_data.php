<?php
include_once("../database/connect.php");
include_once("../components/time_ago.php");

$calender = date('Y-m', strtotime($_POST['calender']));
$Reports = $connect->query("SELECT Users.name AS user_name, Courses.name AS course_name, Enrollments.created_at FROM Enrollments
                            INNER JOIN Users ON Enrollments.student_id = Users.id AND Users.roles = 'student'
                            INNER JOIN Courses ON Enrollments.course_id = Courses.id
                            WHERE DATE_FORMAT(Enrollments.created_at, '%Y-%m') = '$calender'");
$i = 0;
?>

<?php if (!empty($Reports)): ?>
  <?php while ($report = $Reports->fetch_object()): ?>
    <tr style="width: 100%">
      <td><?= ++$i ?></td>
      <td><?= $report->course_name ?></td>
      <td><?= $report->user_name ?></td>
      <td align="center"><?= timeAgo($report->created_at) ?></td>
    </tr>
  <?php endwhile ?>
<?php else: ?>
  <tr>
    <td colspan="4">Tidak ada</td>
  </tr>
<?php endif ?>