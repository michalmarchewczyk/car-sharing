<style lang="postcss" global>
    @import "https://fonts.googleapis.com/icon?family=Material+Icons";

    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    body {
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }

    *:focus-visible {
        outline:none;
    }

    @layer utilities {
        .w-112 {
            width: 28rem;
        }
        .w-128 {
            width: 32rem;
        }
    }
</style>
