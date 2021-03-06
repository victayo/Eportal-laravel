<div class="eportal-form mb-3" ng-controller="PropertyController">
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="session">Session</label>
            <select class="form-control" name="session" id="session" required
                    ng-model="property.session"
                    ng-options="session.id as session.name for session in sessions">
                <option value="">Select Session</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="term">Term</label>
            <select class="form-control" name="term" id="term" required
                    ng-model="property.term"
                    ng-options="term.id as term.name for term in terms">
                <option value="">Select Term</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="school">School</label>
        <select class="form-control" name="school" id="school" required
                ng-model="property.school"
                ng-options="school.id as school.name for school in schools">
            <option value="">Select School</option>
        </select>
    </div>
    <div class="form-group">
        <label for="class">Class</label>
        <select class="form-control" name="class" id="class" required
                ng-model="property.class"
                ng-options="class.id as class.name for class in classes">
            <option value="">Select Class</option>
        </select>
    </div>
    <div class="form-row">
        @if(in_array('department', $fields))
        <div class="col-md-6 mb-3">
            <label for="department">Department</label>
            <select class="form-control" name="department" id="department"
                    ng-model="property.department"
                    ng-required="hasDepartment"
                    ng-options="department.id as department.name for department in departments">
                <option value="">Select Department</option>
            </select>
        </div>
        @endif
        @if(in_array('subject', $fields))
        <div class="col-md-6 mb-3">
            <label for="subject">Subject</label>
            <select class="form-control" name="subject" id="subject"
                    ng-model="property.subject"
                    ng-required="hasSubject"
                    ng-options="subject.id as subject.name for subject in subjects">
                <option value="">Select Subject</option>
            </select>
        </div>
        @endif
    </div>
</div>