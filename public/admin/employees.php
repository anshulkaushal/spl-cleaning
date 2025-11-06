<?php
/**
 * Admin Employees Management
 */

$pageTitle = 'Manage Employees';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Employee.php';

$employeeModel = new Employee();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_employee'])) {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $role = sanitize($_POST['role']);
        
        if ($employeeModel->create($name, $email, $phone, $role)) {
            redirectWithMessage('/admin/employees.php', 'Employee created successfully');
        } else {
            redirectWithMessage('/admin/employees.php', 'Failed to create employee', 'error');
        }
    } elseif (isset($_POST['update_employee'])) {
        $id = intval($_POST['employee_id']);
        $data = [
            'name' => sanitize($_POST['name']),
            'email' => sanitize($_POST['email']),
            'phone' => sanitize($_POST['phone']),
            'role' => sanitize($_POST['role']),
            'active_status' => isset($_POST['active_status']) ? 1 : 0
        ];
        
        if ($employeeModel->update($id, $data)) {
            redirectWithMessage('/admin/employees.php', 'Employee updated successfully');
        } else {
            redirectWithMessage('/admin/employees.php', 'Failed to update employee', 'error');
        }
    } elseif (isset($_POST['delete_employee'])) {
        $id = intval($_POST['employee_id']);
        if ($employeeModel->delete($id)) {
            redirectWithMessage('/admin/employees.php', 'Employee deleted successfully');
        } else {
            redirectWithMessage('/admin/employees.php', 'Failed to delete employee', 'error');
        }
    }
}

$employees = $employeeModel->getAll();
?>

<h1 class="h2 mb-4">Manage Employees</h1>

<!-- Create Employee Button -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
    <i class="bi bi-plus-circle"></i> Add New Employee
</button>

<!-- Employees Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo $employee['id']; ?></td>
                        <td><?php echo htmlspecialchars($employee['name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['email']); ?></td>
                        <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                        <td><?php echo htmlspecialchars($employee['role']); ?></td>
                        <td>
                            <?php if ($employee['active_status']): ?>
                            <span class="badge bg-success">Active</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEmployeeModal<?php echo $employee['id']; ?>">
                                Edit
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Employee Modal -->
                    <div class="modal fade" id="editEmployeeModal<?php echo $employee['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <input type="text" name="role" class="form-control" value="<?php echo htmlspecialchars($employee['role']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" name="active_status" class="form-check-input" id="active<?php echo $employee['id']; ?>" 
                                                   <?php echo $employee['active_status'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="active<?php echo $employee['id']; ?>">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="update_employee" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Employee Modal -->
<div class="modal fade" id="createEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" name="role" class="form-control" value="Cleaner" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="create_employee" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

