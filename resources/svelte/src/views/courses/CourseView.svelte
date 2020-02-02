<script>
    import { onMount } from 'svelte';
    import { Navigate, navigateTo, Route  } from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';

    dayjs.locale('pl')

    export let currentRoute;
    let courseId = currentRoute.namedParams.id;
    let course = null;

    let lessons = [];
    let studentSearchList = [];

    let checkAttendance = (studentId, courseId, lesson) => {
        let attendanceData = new FormData();
        attendanceData.append("student_id",studentId);
        attendanceData.append("course_id",courseId);
        attendanceData.append("lesson",lesson);
        TitarAPI.post("https://course.dev.titarlab.com/api/attendances",attendanceData).then((response) => {
            getCourse(course.id);
            UIkit.notification(response.message, "success");
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
        });
    }

    let attendanceHandler = (studentId= null, courseId= null, lesson = null) =>{
        checkAttendance(studentId, courseId, lesson);
    }

    let getCourse = (id) => {
        TitarAPI.get("https://course.dev.titarlab.com/api/courses/"+id).then((response) => {
            course = response.data;
            lessons = [];
            for(let i = 0; i < course.lessons; i++){
                lessons.push(i+1);
            }
        }).catch((err) => {
            course = null;
            console.error(err);
        })
    }


    onMount(() => {
        getCourse(courseId);
    })

    let searchValue = "";
    let searchStudentForCourse = () => {
        if(searchValue.length > 3){
            TitarAPI.get("https://course.dev.titarlab.com/api/students?search="+searchValue+"&course_id="+course.id).then((response) => {
                studentSearchList = response.data;
            }).catch((err) => {
                studentSearchList = [];
                console.error(err);
            })
        }else{
            studentSearchList = []
        }
    }

    let deleteModal = (successCallback) => {
        UIkit.modal.confirm('Usunąć przedmiot i wszystkie powiązane z nim dane?', {
            cancel: 'Powrót',
            ok: 'Usuń'
        }).then(function() {
            successCallback();
        }, function () {

        });
    }

    let deleteHandler = () => {
        TitarAPI.delete("https://course.dev.titarlab.com/api/courses/"+course.id).then((response) => {
            UIkit.notification(response.message, "success");
            navigateTo('courses');
        }).catch(()=>{

        });
    }

    let deleteStudentAssignedModal = (successCallback, studentId) => {
        UIkit.modal.confirm('Usunąć studenta z tego przedmiotu?', {
            cancel: 'Powrót',
            ok: 'Usuń'
        }).then(function() {
            successCallback(studentId);
        }, function () {

        });
    }

    let deleteStudentAssignedHandler = (studentId) => {
        TitarAPI.delete("https://course.dev.titarlab.com/api/courses/"+course.id+"/students/"+studentId).then((response) => {
            UIkit.notification(response.message, "success");
            searchStudentForCourse();
            getCourse(course.id);
        }).catch(()=>{

        });
    }

    let deleteTestModal = (successCallback, testId) => {
        UIkit.modal.confirm('Usunąć tą ocenę?', {
            cancel: 'Powrót',
            ok: 'Usuń'
        }).then(function() {
            successCallback(testId);
        }, function () {

        });
    }

    let deleteTestHandler = (testId) => {
        TitarAPI.delete("https://course.dev.titarlab.com/api/tests/"+testId).then((response) => {
            UIkit.notification(response.message, "success");
            getCourse(course.id);
        }).catch(()=>{

        });
    }

    let addStudent = (studentId) => {
        let data = new FormData();
        data.append("student_id",studentId);
        TitarAPI.post("https://course.dev.titarlab.com/api/courses/"+course.id+"/students",data).then((response) => {
            UIkit.notification(response.message, "success");
            searchStudentForCourse();
            getCourse(course.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }

    let updateTestHandler = (event, testId) => {
        event.preventDefault();
        let data = new FormData(event.target);
        TitarAPI.post("https://course.dev.titarlab.com/api/tests/"+testId,data).then((response) => {
            UIkit.notification(response.message, "success");
            getCourse(course.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }

    let createTestHandler = (event) => {
        event.preventDefault();
        let data = new FormData(event.target);
        TitarAPI.post("https://course.dev.titarlab.com/api/tests",data).then((response) => {
            UIkit.notification(response.message, "success");
            getCourse(course.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }

    let updateTestTypeHandler = (event, testTypeId) => {
        event.preventDefault();
        let data = new FormData(event.target);
        TitarAPI.post("https://course.dev.titarlab.com/api/test-types/"+testTypeId,data).then((response) => {
            UIkit.notification(response.message, "success");
            getCourse(course.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }

    let createTestTypeHandler = (event) => {
        event.preventDefault();
        let data = new FormData(event.target);
        TitarAPI.post("https://course.dev.titarlab.com/api/test-types",data).then((response) => {
            UIkit.notification(response.message, "success");
            getCourse(course.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }

    let deleteTestTypeModal = (successCallback, testTypeId) => {
        UIkit.modal.confirm('Usunąć tą ocenę?', {
            cancel: 'Powrót',
            ok: 'Usuń'
        }).then(function() {
            successCallback(testTypeId);
        }, function () {

        });
    }

    let deleteTestTypeHandler = (testTypeId) => {
        TitarAPI.delete("https://course.dev.titarlab.com/api/test-types/"+testTypeId).then((response) => {
            UIkit.notification(response.message, "success");
            getCourse(course.id);
        }).catch(()=>{

        });
    }



    let calcMark = (student) => {
        let mark = 0;
        let totalWeight = 0;

        if(student !== null && student.tests != null && course != null){
            let minMark = null
            let minMarkWeight = null

            if(course.attendancesObj[student.id] != null){
                console.log(course.attendancesObj[student.id])
                if(Object.keys(course.attendancesObj[student.id]).length >= course.lessons){
                    student.tests.forEach((test) => {
                        if(test.type.is_student_option == true){
                            if(minMark === null){
                                minMark = test.mark;
                                minMarkWeight = test.type.weight;
                            }
                            if(minMark * minMarkWeight > test.mark * test.type.weight){
                                minMark = test.mark
                                minMarkWeight = test.type.weight;
                            }
                        };
                    })
                }
            }


            student.tests.forEach((test) => {
                mark += test.mark * test.type.weight;
                totalWeight += test.type.weight;
            })
            if(totalWeight == 0){
                return 0;
            }else{
                if(minMark != null){
                    return mark = (Math.max((mark - minMark) / (totalWeight - minMarkWeight), mark / totalWeight)).toFixed(3);
                }else{
                    return (mark = mark / totalWeight).toFixed(2);
                }
            }
        }
        return 0;



    }

</script>


{#if course == null }
    <div uk-height-viewport="expand: true" class="uk-flex uk-flex-center uk-flex-middle">
        <span uk-spinner="ratio: 4.5"></span>
    </div>

{:else if course != null}
    <div class="uk-card uk-card-small uk-card-default uk-width-1-1">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <h3 class="uk-card-title uk-margin-remove">Przedmiot Id: {course.id}</h3>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto uk-width-1-1">
            <div class="uk-grid">
                <dl class="uk-description-list">
                    <dt>Nazwa</dt>
                    <dd>{course.name}</dd>
                </dl>
                <dl class="uk-description-list">
                    <dt>Ilość zajęcz</dt>
                    <dd>{course.lessons}</dd>
                </dl>
                <dl class="uk-description-list">
                    <dt>Zaczyna się</dt>
                    <dd>{course.started_at}</dd>
                </dl>
                <dl class="uk-description-list">
                    <dt>Kończy się</dt>
                    <dd>{course.ended_at}</dd>
                </dl>
            </div>
        </div>
        <div class="uk-card-footer">
            <Navigate styles="uk-button uk-button-default" to="/courses/edit/{course.id}">
                Edytować
            </Navigate>
            <Navigate styles="uk-button uk-button-default" to="/courses">
                Powrót
            </Navigate>
            <button on:click={()=>{deleteModal(deleteHandler)}} class="uk-button uk-button-default uk-button-danger">
                Usuń
            </button>

        </div>
    </div>

    <div class="uk-card uk-card-small uk-card-default uk-width-1-1">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <h3 class="uk-card-title uk-margin-remove">Lista obecności</h3>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto uk-width-1-1">
            <table class="uk-table uk-table-hover uk-table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        {#each lessons as lesson}
                            <th>{lesson}</th>
                        {/each}
                        <th class="uk-flex uk-flex-right">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    {#each course.students as student}
                        <tr>
                            <td>{student.firstname} {student.lastname} ({student.index})</td>
                            {#each lessons as lesson}
                                <td>
                                    {#if course.attendancesObj[student.id] != null && course.attendancesObj[student.id][lesson] != null}
                                        <input on:change={()=>{attendanceHandler(student.id, course.id, lesson);}} checked type="checkbox" class="uk-checkbox">
                                    {:else}
                                        <input on:change={()=>{attendanceHandler(student.id, course.id, lesson)}} type="checkbox" class="uk-checkbox">
                                    {/if}
                                </td>
                            {/each}
                            <td class="uk-flex uk-flex-right">
                                <button on:click={()=>{deleteStudentAssignedModal(deleteStudentAssignedHandler,student.id)}} class="uk-button uk-button-danger">
                                    Usuń
                                </button>
                            </td>
                        </tr>

                    {/each}
                </tbody>
            </table>
        </div>
        <div class="uk-card-footer">
            <div class="uk-margin">
                <div class="uk-search uk-search-default">
                    <span uk-search-icon></span>
                    <input bind:value={searchValue} on:change={searchStudentForCourse} class="uk-search-input" type="search" placeholder="Poszuk studenta">
                </div>
            </div>
            <table class="uk-table uk-table-small uk-table-divider uk-table-hover uk-table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Numer indeksu</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Email</th>
                    <th class="uk-text-right">Akcje</th>
                </tr>
                </thead>
                <tbody>
                {#each studentSearchList as student}
                    <tr>
                        <td>{student.id}</td>
                        <td>{student.index}</td>
                        <td>{student.firstname}</td>
                        <td>{student.lastname}</td>
                        <td>{student.email}</td>
                        <td class="uk-text-right">
                            <button on:click={()=>{addStudent(student.id)}} class="uk-button uk-button-primary">
                                Dodaj
                            </button>
                        </td>
                    </tr>
                {/each}
                </tbody>
            </table>
        </div>
    </div>

    <div class="uk-card uk-card-small uk-card-default uk-width-1-1">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <h3 class="uk-card-title uk-margin-remove">Formy sprawdzania wiedzy</h3>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto uk-width-1-1">
            <table class="uk-table uk-table-hover uk-table-striped">
                <tbody>
                    {#each course.test_types as testType}
                        <tr>
                            <td>
                                <form on:submit={(event) => {updateTestTypeHandler(event, testType.id);}} class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-4@s">
                                        <input name="name" class="uk-input" type="text" placeholder="Nazwa" value="{testType.name}">
                                    </div>
                                    <div class="uk-width-1-4@s">
                                        <input name="weight" class="uk-input" type="number" step="1" min="1" placeholder="Waga" value="{testType.weight}">
                                    </div>
                                    <div class="uk-width-1-4@s">
                                        {#if testType.is_student_option == true}
                                            <label><input class="uk-checkbox" name="is_student_option" value="1" type="checkbox" checked> Uzwględnia obecność studenta</label>
                                        {:else}
                                            <label><input class="uk-checkbox" name="is_student_option" value="1" type="checkbox"> Uzwględnia obecność studenta</label>

                                        {/if}

                                    </div>
                                    <div class="uk-width-1-4@s">
                                        <button uk-icon="check" class="uk-icon-button"></button>
                                        <a on:click={()=>{ deleteTestTypeModal(deleteTestTypeHandler,testType.id)}} uk-icon="trash" class="uk-icon-button"></a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    {/each}
                    <tr>
                        <td>
                            <form on:submit={(event) => {createTestTypeHandler(event);}} class="uk-grid-small" uk-grid>
                                <input name="course_id" hidden value="{course.id}">
                                <div class="uk-width-1-4@s">
                                    <input name="name" class="uk-input" type="text" placeholder="Nazwa">
                                </div>
                                <div class="uk-width-1-4@s">
                                    <input name="weight" class="uk-input" type="number" step="1" min="1" placeholder="Waga">
                                </div>
                                <div class="uk-width-1-4@s">
                                    <label><input class="uk-checkbox" name="is_student_option" value="1" type="checkbox"> Uzwględnia obecność studenta</label>
                                </div>
                                <div class="uk-width-1-4@s">
                                    <button uk-icon="plus" class="uk-icon-button"></button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="uk-card-footer">

        </div>
    </div>

    <div class="uk-card uk-card-small uk-card-default uk-width-1-1">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <h3 class="uk-card-title uk-margin-remove">Oceny</h3>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto uk-width-1-1">
            <table class="uk-table uk-table-hover uk-table-striped">
                <thead>
                <tr>
                    <td>Student</td>
                    <td>Oceny</td>
                    <td>Końcowa z przedmiotu</td>
                </tr>
                </thead>
                <tbody>
                {#each course.students as student}
                    <tr>
                        <td>{student.firstname} {student.lastname} ({student.index})</td>
                        <td>
                            {#each student.tests as test}
                                <form on:submit={(event) => {updateTestHandler(event, test.id);}} class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-3@s">
                                        <select name="test_type_id" class="uk-select">
                                            {#each course.test_types as testType}
                                                {#if testType.id == test.test_type_id}
                                                    <option selected value="{testType.id}">
                                                        {testType.name}
                                                    </option>
                                                {:else}
                                                    <option value="{testType.id}">
                                                        {testType.name}
                                                    </option>
                                                {/if}
                                            {/each}
                                        </select>
                                    </div>
                                    <div class="uk-width-1-3@s">
                                        <input name="mark" class="uk-input" type="number" step="0.5" min="1" max="5" placeholder="Ocena" value="{test.mark}">
                                    </div>
                                    <div class="uk-width-1-3@s">
                                        <button uk-icon="check" class="uk-icon-button"></button>
                                        <a on:click={()=>{ deleteTestModal(deleteTestHandler,test.id)}} uk-icon="trash" class="uk-icon-button"></a>
                                    </div>
                                </form>
                            {/each}
                            <form on:submit={createTestHandler} class="uk-grid-small" uk-grid>
                                <input name="student_id" hidden value="{student.id}">
                                <input name="course_id" hidden value="{course.id}">
                                <div class="uk-width-1-3@s">
                                    <select name="test_type_id" class="uk-select">
                                        {#each course.test_types as testType}
                                            <option value="{testType.id}">
                                                {testType.name}
                                            </option>
                                        {/each}
                                    </select>
                                </div>
                                <div class="uk-width-1-3@s">
                                    <input name="mark" class="uk-input" type="number" step="0.5" min="1" max="5" placeholder="Nowa ocena">
                                </div>
                                <div class="uk-width-1-3@s">
                                    <button uk-icon="plus" class="uk-icon-button"></button>
                                </div>
                            </form>
                        </td>
                        <td>
                            {calcMark(student)}
                        </td>
                    </tr>
                {/each}
                </tbody>
            </table>
        </div>
        <div class="uk-card-footer">

        </div>
    </div>
{/if}


