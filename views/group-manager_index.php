<script>
$(function() {
	YodaPortal.groupManager.load(<?= json_encode($groupHierarchy) ?>);
});
</script>

<h1>Group Manager</h1>

<div class="row">
	<div class="col-md-5">
		<div class="panel panel-default groups">
			<div class="panel-heading clearfix">
				<h3 class="panel-title pull-left">Yoda groups</h3>
				<div class="input-group-sm has-feedback pull-right hidden">
					<!-- TODO: Search groups. -->
					<input class="form-control input-sm" id="group-list-search" type="text" placeholder="Search groups" />
					<i class="glyphicon glyphicon-search form-control-feedback"></i>
				</div>
			</div>
			<div class="list-group" id="group-list">
<?php
	$i = 0;
	$j = 0;
	$k = 0;

	ksort($groupHierarchy);
	foreach ($groupHierarchy as $category => $subcategories) {
?>
	<div class="list-group-item category" id="category-<?=$i?>" data-name="<?=$category?>">
		<a class="name collapsed" data-toggle="collapse" data-parent="#category-<?=$i?>" href="#category-<?=$i?>-ul">
			<i class="glyphicon glyphicon-triangle-right triangle"></i>
			<?=$category?>
		</a>
		<div class="list-group collapse category-ul" id="category-<?=$i?>-ul">
<?php
		ksort($subcategories);
		foreach ($subcategories as $subcategory => $groups) {
?>
	<div class="list-group-item subcategory" data-name="<?=$subcategory?>"><div class="name"><?=$subcategory?></div>
	<div class="list-group subcategory-ul">
<?php
			ksort($groups);
			foreach ($groups as $group => $properties) {
?>
				<a class="list-group-item group" id="group-<?=$k?>" data-name="<?=$group?>">
					<?=$group?>
				</a>
<?php
				$k++;
			}
?>
	</div>
	</div>
<?php
			$j++;
		}
?>
	</div>
	</div>
<?php
		$i++;
	}
?>
			</div>
			<div class="panel-footer clearfix">
				<div class="input-group-sm pull-left">
					<a class="btn btn-sm btn-danger disabled delete-button hidden">Remove group</a>
				</div>
				<div class="input-group-sm pull-right">
					<a class="btn btn-sm btn-primary create-button" data-toggle="modal" data-target="#modal-group-create">Add group</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="panel panel-default properties">
			<div class="panel-heading">
				<h3 class="panel-title">Group properties</h3>
			</div>
			<div class="panel-body" id="group-properties">
				<p class="placeholder-text">
					Please select a group.
				</p>
				<form action="<?=base_url('group-manager/group-update')?>" method="POST" class="form-horizontal hidden" id="f-group-update">
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-update-category">Category</label>
						<div class="col-sm-8">
							<input name="group_category" id="f-group-update-category" class="form-control selectify-category" type="hidden" placeholder="Select one or enter a new name" required data-subcategory="#f-group-update-subcategory" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-update-subcategory">Subcategory</label>
						<div class="col-sm-8">
							<input name="group_subcategory" id="f-group-update-subcategory" class="form-control selectify-subcategory" type="hidden" placeholder="Select one or enter a new name" required data-category="#f-group-update-category" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-update-name">Name</label>
						<div class="col-sm-8">
							<div class="input-group">
								<div class="input-group-addon">grp-</div>
								<input name="group_name" id="f-group-update-name" class="form-control" type="text" pattern="^[a-z0-9\-]+$"	required oninvalid="setCustomValidity(\'Please enter only lowercase letters, numbers, and hyphens (-).\')" onchange="setCustomValidity(\'\')" readonly />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-update-description">Description</label>
						<div class="col-sm-8">
							<input name="group_description" id="f-group-update-description" class="form-control" type="text" placeholder="Enter a short description for this group" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<input id="f-group-update-submit" class="btn btn-primary" type="submit" value="Update" />
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-default users">
			<div class="panel-heading clearfix">
				<h3 class="panel-title pull-left">Group members</h3>
				<div class="input-group-sm has-feedback pull-right">
					<input class="form-control input-sm" id="user-list-search" type="text" placeholder="Search users" />
					<i class="glyphicon glyphicon-search form-control-feedback"></i>
				</div>
			</div>
			<div class="panel-body">
				<p class="placeholder-text">
					Please select a group.
				</p>
			</div>
			<div class="list-group hidden" id="user-list">
				<div class="list-group-item item-user-create">
					<span class="placeholder-text">
						Click here to add a new user to this group
					</span>
					<form action="<?=base_url('group-manager/user-create')?>" method="POST" class="form-inline hidden" id="f-user-create">
						<input name="group_name" id="f-user-create-group" type="hidden" />
						<div class="input-group" style="width: 100%;">
							<input name="user_name" id="f-user-create-name" class="form-control input-sm selectify-user-name" type="hidden" pattern="^[a-z0-9\-]+$" required oninvalid="setCustomValidity('Please enter only lowercase letters, numbers, and hyphens (-).')" onchange="setCustomValidity('')" placeholder="Enter a username" data-group="#f-user-create-group" />
							<div class="input-group-btn">
								<input id="f-user-create-submit" class="btn btn-primary btn-block btn-sm" type="submit" value="Add" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="panel-footer clearfix" style="border-top: 1px solid #ddd;">
				<div class="input-group-sm pull-left">
					<a class="btn btn-sm btn-primary disabled update-button" title="Change whether the selected user is a manager in this group">Change role</a>
					<a class="btn btn-sm btn-danger disabled delete-button" title="Remove the selected user from this group">Remove</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-group-create" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Create a group</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="f-group-create" action="<?=base_url('group-manager/group-create')?>" method="POST">
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-create-category">Category</label>
						<div class="col-sm-8">
							<input name="group_category" id="f-group-create-category" class="form-control selectify-category" type="hidden" placeholder="Select one or enter a new name" required data-subcategory="#f-group-create-subcategory" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-create-subcategory">Subcategory</label>
						<div class="col-sm-8">
							<input name="group_subcategory" id="f-group-create-subcategory" class="form-control selectify-subcategory" type="hidden" placeholder="Select one or enter a new name" required data-category="#f-group-create-category" />
						</div>
					</div>
					<hr />
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-create-name">Group name</label>
						<div class="col-sm-8">
							<div class="input-group">
								<div class="input-group-addon">
									grp-
								</div>
								<input name="group_name" id="f-group-create-name" class="form-control" type="text" pattern="^[a-z0-9\-]+$"  required oninvalid="setCustomValidity('Please enter only lowercase letters, numbers, and hyphens (-).')" onchange="setCustomValidity('')" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="f-group-create-description">Group description</label>
						<div class="col-sm-8">
							<input name="group_description" id="f-group-create-description" class="form-control" type="text" placeholder="Enter a short description" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<input id="f-group-create-submit" class="btn btn-primary" type="submit" value="Add group" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
