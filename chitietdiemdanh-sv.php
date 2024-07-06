<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php include 'connect.php'; ?>
        <?php
        session_start();
        $u = $_SESSION['username'];
        $id = $_GET['id'];

        $sql = "SELECT att.attendance_id, att.class_id, att.student_id, att.attendance_date, att.status, att.lydo, stu.fullname, c.class_name
                FROM attendances att
                INNER JOIN classes c ON c.class_id = att.class_id
                INNER JOIN student stu ON att.student_id = stu.student_id 
                WHERE att.class_id = ? AND stu.username = ?";

        $arrParam = [$id, $u];
        $stm = $conn->prepare($sql);
        $stm->execute($arrParam);
        $data = $stm->fetchAll(PDO::FETCH_OBJ);
        foreach($data as $item)
            {
                 $classname = $item->class_name;
            }

        echo "<h2 class='mb-4'>Attendance Details for Class ID: " . htmlspecialchars($classname) . "</h2>";
        ?>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã lớp</th>
                    <th>Mã sinh viên</th>
                    <th>Họ và tên</th>
                    <th>Ngày điểm danh</th>
                    <th>Trạng thái</th>
                    <th>Lý do</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item->class_id); ?></td>
                    <td><?php echo htmlspecialchars($item->student_id); ?></td>
                    <td><?php echo htmlspecialchars($item->fullname); ?></td>
                    <td><?php echo htmlspecialchars($item->attendance_date); ?></td>
                    <td><?php echo htmlspecialchars($item->status); ?></td>
                    <td><?php echo htmlspecialchars($item->lydo); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <a href="student.php" class="btn btn-primary mt-3">Back to Classes</a>
        <a href="./logout.php" class="btn btn-danger mt-3">Log Out</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
