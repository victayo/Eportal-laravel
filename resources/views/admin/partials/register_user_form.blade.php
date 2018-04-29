<div class="eportal-form mb-3" ng-controller="UserController">
    <div class="form-row mb-3">
        <div class="col-md-4">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" ng-model="details.first_name">
        </div>
        <div class="col-md-4">
            <label for="middle_name">Middle Name</label>
            <input type="text" id="middle_name" name="middle_name" class="form-control" ng-model="details.middle_name">
        </div>
        <div class="col-md-4">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" ng-model="details.last_name">
        </div>
    </div>
    <div class="form-group">
        <label for="username">Registration Number</label>
        <input type="text" id="username" name="username" class="form-control" ng-model="details.username">
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" ng-model="details.gender">
                <option value="">Select Gender</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" class="form-control" ng-model="details.dob">
        </div>
    </div>
</div>
