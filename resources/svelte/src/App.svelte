<script>
	import AuthHelper from './helpers/AuthHelper';
	import Auth from './layouts/Auth.svelte';
	import AppLayout from './layouts/AppLayout.svelte';
</script>

{#if AuthHelper.checkAuth()}
	<AppLayout/>
{:else}
	<Auth/>
{/if}

