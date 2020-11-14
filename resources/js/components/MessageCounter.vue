<template>
    <span v-if="count">{{ count}}</span>
</template>
<script>
export default {
    mounted() {
        this.getCount().then(data => {
            this.count = data;
        });
    },
    data: function () {
        return {
            count: 0
        }
    },
    methods: {
        getCount: function () {
            let d = $.Deferred();

            axios.get('/api-admin/support/messages-count')
                .then((response) => {
                    d.resolve(response.data.count);
                });

            return d.promise();
        }
    }
}
</script>
