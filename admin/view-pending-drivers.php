<?php
include_once("../config.php");
include 'admin-header.php';

$result = mysqli_query($mysqli, "SELECT * FROM pending_drivers ORDER BY id DESC");
?>

<style>
    .content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-left: 260px; /* for sidebar space */
        min-height: 100vh;
    }
</style>

<div class="content">
    <h3 class="mb-4 text-center">Pending Driver Approvals</h3>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Email</th>
                <th>License</th>
                <th>Location</th>
                <th>Lat/Lng</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['photo']) && file_exists("../images/driver/" . $row['photo'])): ?>
                                <img src="../images/driver/<?php echo $row['photo']; ?>" width="60" height="60" style="border-radius:50%; object-fit:cover;">
                            <?php else: ?>
                                <span>No photo</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['lno']; ?></td>
                        <td><?php echo $row['location_name']; ?></td>
                        <td><?php echo $row['latitude'] . ', ' . $row['longitude']; ?></td>
                        <td>
                            <a href="approve-driver.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                            <a href="reject-driver.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this driver?');">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9">No pending drivers found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
