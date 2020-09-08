<?php require APP_ROOT."/views/inc/header.php"; ?>

<section id="dashboard">
	<div class="dashboard-content">
		<h3><?= ucfirst($data["role"]); ?> Dashboard</h3>
		
		<?php if ($data["status"]): ?>
		<p><?= $data["status"] ?></p>
		<?php endif; ?>
		
		<?php if (count($data["applications"]) > 0): ?>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Applied</th>
					<?php if ($data["role"] == "approver"): ?>
					<th>
						<?php require APP_ROOT."/views/inc/filter.php"; ?>
					</th>
					<th>Recorded</th>
					<?php elseif ($data["role"] == "cashier"): ?>
					<th>Approved</th>
					<th>
						<?php require APP_ROOT."/views/inc/filter.php"; ?>
					</th>
					<?php else: ?>
					<th>Approved</th>
					<th>Recorded</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data["applications"] as $application): 
					$fullName = "{$application->first} {$application->last}";
					$dateSubmitted = empty($application->dateSubmitted) ? "---" : date("n/j/Y", strtotime($application->dateSubmitted));
					$dateApproved  = empty($application->dateApproved)  ? "---" : date("n/j/Y", strtotime($application->dateApproved));
					$dateRecorded  = empty($application->dateRecorded)  ? "---" : date("n/j/Y", strtotime($application->dateRecorded));
				
					if ($data["role"] === "approver") {
						if (empty($application->dateApproved)) {
							$dateApproved = "<a href=\"applications/approve/{$application->appId}\">approve</a>";
						}
					}
					elseif ($data["role"] === "cashier") {
						if (!empty($application->dateApproved) && empty($application->dateRecorded)) {
							$dateRecorded = "<a href=\"applications/record/{$application->appId}\">record</a>";
						}
					}
				?>
				<tr>
					<td><?= $fullName; ?></td>
					<td><?= $dateSubmitted; ?></td>
					<td><?= $dateApproved; ?></td>
					<td><?= $dateRecorded; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
</section>

<?php require APP_ROOT."/views/inc/footer.php"; ?>