<script>
    import { onMount } from 'svelte';
    import { Navigate, Route  } from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';
    import { navigateTo } from 'svelte-router-spa'

    dayjs.locale('pl')

    let formHandler = (event) => {
        event.preventDefault();
        let studentData = new FormData(event.target);
        console.log(studentData)
        TitarAPI.post("https://course.dev.titarlab.com/api/students",studentData).then((response) => {
            UIkit.notification(response.message, "success");
            navigateTo('students/show/'+response.data.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }



</script>


<div class="uk-card uk-card-small uk-card-default uk-width-1-1">
    <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
        <div class="uk-flex uk-flex-between uk-flex-middle">
            <h3 class="uk-card-title uk-margin-remove">Nowy student</h3>
        </div>
    </div>
    <form on:submit={formHandler} id="new" class="uk-card-body uk-overflow-auto uk-width-1-1">
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Imię</label>
            <div class="uk-form-controls">
                <input required class="uk-input" type="text" name="firstname" placeholder="Imię">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Nazwisko</label>
            <div class="uk-form-controls">
                <input required class="uk-input" type="text" name="lastname" placeholder="Nazwisko" >
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Numer indeksu</label>
            <div class="uk-form-controls">
                <input required class="uk-input" type="number" name="index" placeholder="Numer indeksu">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Email</label>
            <div class="uk-form-controls">
                <input required class="uk-input" type="email" name="email" placeholder="Email">
            </div>
        </div>
    </form>
    <div class="uk-card-footer">
        <button form="new" class="uk-button uk-button-primary">Zapisz</button>
        <Navigate styles="uk-button uk-button-default" to="/students">
            Powrót
        </Navigate>
    </div>
</div>


