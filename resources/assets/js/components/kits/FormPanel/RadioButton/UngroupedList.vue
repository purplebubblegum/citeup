
<template>
    <div class="btn-group">
        <item v-for="(data, id, index) in list" :key="index" :id="id" :state="id == passableValue" @check="input">
            <slot name="list" :data="data" :id="id"></slot>
        </item>
    </div>
</template>

<script>

    import Item from './item'

    export default {

        props: {

            name: {
                type: String,
                required: true
            },

            list: {
                type: Object,
                required: true,
            },

            grouped: {
                type: Boolean,
                default: true,
            },

            labeled: {
                type: Boolean,
                default: true
            },

            labelWidth: {
                type: Number,
                default: 0,
            },

            controlWidth: {
                type: Number,
                default: 0,
            },

            value: {
                type: [Number, String]
            },

        },

        data() {
            return {
                passableValue: this.value
            }
        },

        computed: {

            horizontal() {
                this.labelWidth > 0 && this.controlWidth > 0
            },

            labelColumn() {
                return this.labelWidth > 0 ? 'col-sm-' + this.labelWidth : ''
            },

            controlColumn() {
                return this.controlWidth > 0 ? 'col-sm-' + this.controlWidth : ''
            },

        },

        watch: {
            value(newVal) {
                this.$emit('input', newVal)
            }
        },

        mounted() {
            // this.prepareComponent()
        },

        methods: {

            input(value) {
                this.$emit('input', value)
            },

        },

        components: {
            'item': Item,
        }

    }

</script>
