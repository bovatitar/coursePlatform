<nav class="uk-navbar-container uk-margin uk-light" uk-navbar>
    <div class="uk-navbar-left uk-flex-1 uk-background-primary">

        <a class="uk-navbar-item uk-logo" href="#">CoursePlatform</a>

        <ul class="uk-navbar-nav">
            {#each menu as menuItem}
                <li>
                    <Navigate to="{menuItem.to}">{menuItem.name}</Navigate>
                </li>
            {/each}
        </ul>
    </div>
    <div class="uk-navbar-right uk-background-primary">
        <ul class="uk-navbar-nav">
            <li>
                <div class="uk-navbar-item" on:click={AuthHelper.logout} uk-tooltip="Wyloguj się">
                    <span uk-icon="sign-out"></span>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    import {Navigate} from 'svelte-router-spa'
    import AuthHelper from '../../helpers/AuthHelper'
    export let menu = [];
</script>
