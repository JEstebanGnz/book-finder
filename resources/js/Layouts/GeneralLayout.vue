<template>
    <v-app>
        <!--CUSTOM NAVIGATION DRAWER SLOT-->
        <slot name="custom-navigation-drawer"></slot>
        <!--CUSTOM NAVIGATION DRAWER SLOT-->


        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid class="fill-height align-start">
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>

</template>
<script>
import {Link} from '@inertiajs/inertia-vue';

export default {
    components: {
        Link
    },
    data: () => ({
        siteName: 'Librería Pérgamo',
    }),

    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    }
}
</script>
