<template>
    <span v-if="$parent.messages_count">{{ $parent.messages_count }}</span>
</template>
<script>
export default {
    mounted() {
        this.$parent.getCount().then(data => {
            this.$parent.messages_count = data;
        });
    },
}
</script>
