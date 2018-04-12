<template>
    <div class="loader-container">
        <div class="loader">
            <svg class="circular-loader"viewBox="25 25 50 50" >
                <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke='#ffffff' stroke-width="3" />
            </svg>
        </div>
    </div>
</template>

<style>
    .loader-container {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        width:100%;
        height:100%;
        z-index: 99;
        font-size: 3em;
        color: white;
    }

    .loader {
        margin: 0px auto;
        width: 100px;
        height:100px;
    }

    .circular-loader {
        -webkit-animation: rotate 2s linear infinite;
                animation: rotate 2s linear infinite;
        height: 100%;
        -webkit-transform-origin: center center;
            -ms-transform-origin: center center;
                transform-origin: center center;
        width: 100%;
        margin: auto;
    }

    .loader-path {
        stroke-dasharray: 150,200;
        stroke-dashoffset: -10;
        -webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
                animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
        stroke-linecap: round;
    }

    @-webkit-keyframes rotate {
        100% {
            -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
        }
    }

    @keyframes rotate {
        100% {
            -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
        }
    }

    @-webkit-keyframes dash {
        0% {
            stroke-dasharray: 1,200;
            stroke-dashoffset: 0;
        }
        50% {
            stroke-dasharray: 89,200;
            stroke-dashoffset: -35;
        }
        100% {
            stroke-dasharray: 89,200;
            stroke-dashoffset: -124;
        }
    }

    @keyframes dash {
        0% {
            stroke-dasharray: 1,200;
            stroke-dashoffset: 0;
        }
        50% {
            stroke-dasharray: 89,200;
            stroke-dashoffset: -35;
        }
        100% {
            stroke-dasharray: 89,200;
            stroke-dashoffset: -124;
        }
    }

    @-webkit-keyframes color {
        0% {
            stroke: #fff;
        }
        40% {
            stroke: #fff;
        }
        66% {
            stroke: #fff;
        }
        80%, 90% {
            stroke: #fff;
        }
    }

    @keyframes color {
        0% {
            stroke: #fff;
        }
        40% {
            stroke: #fff;
        }
        66% {
            stroke: #fff;
        }
        80%, 90% {
            stroke: #fff;
        }
    }
</style>

<script>
    export default {
        mounted() {
            //
        },
	}
</script>