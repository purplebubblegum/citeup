
<template>
    <question-select v-if="working"></question-select>
    <finished-view v-else-if="finished"></finished-view>
    <countdown-view v-else></countdown-view>
</template>

<script>

    import { mapGetters } from 'vuex'
    import FinishedView from './logika/FinishedView.vue'
    import CountdownView from './logika/CountdownView.vue'
    import QuestionSelect from './logika/QuestionSelect.vue'

    const GETTERS_STAGE = ['working', 'finished']
    
    export default {
        computed: mapGetters('stage', GETTERS_STAGE),
        components: {
            'finished-view': FinishedView,
            'countdown-view': CountdownView,
            'question-select': QuestionSelect,
        },
    }

</script>