<script>
import Header from "../views/components/Header.vue";
import Banner from "../views/components/Banner.vue";
import Footer from "../views/components/Footer.vue";

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Banner,
        Footer
    },
    created(){
        this.getIndex();
    },
    methods: {
        ...mapActions([
            "getIndex"
        ])
    }
}

</script>
<template>
    <Header />
    <Banner />
    <Footer />
</template>
