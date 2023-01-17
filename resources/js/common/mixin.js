const mixin = {
    methods: {
        confirm(message) {
            return confirm(message);
        },

        errorMessage(message) {
            $.notify({
                content : message,
                alertType: "alert-danger",
                timeout: 8000,
            });
        },

        successMessage(message) {
            $.notify({
                content : message,
                alertType: "alert-success",
                timeout: 8000,
            });
        },

        warningMessage(message) {
            $.notify({
                content : message,
                alertType: "alert-warning",
                timeout: 8000,
            });
        }

    }
}

export default mixin;
