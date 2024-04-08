<template>
    <v-app>
        <v-app-bar app color="#db5523" class="white--text" elevate-on-scroll>
            <slot name="custom-v-app-bar-icon"></slot>
            <Link href="/" class="mr-2">
                <img src="/images/pergamo.png"
                     style="max-height: 60px; max-width:255px; object-fit: contain"
                >

            </Link>
            <v-toolbar-title class="shrink-on-scroll d-none d-md-block">
                <span class="brand__title">
                {{ siteName }}
                </span>
            </v-toolbar-title>


            <v-spacer></v-spacer>

            <!--CUSTOM APP BAR CONTENT SLOT-->
            <slot name="app-bar-content"></slot>
            <!--CUSTOM APP BAR CONTENT SLOT-->


        </v-app-bar>
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

        <v-footer app padless color="#db5523">
            <v-col
                class="text-center"
                cols="12"
            >
                <span class="white--text">
                    {{ new Date().getFullYear() }} — <strong>Librería Pérgamo</strong>
                </span>
            </v-col>
        </v-footer>
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
