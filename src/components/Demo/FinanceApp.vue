<template>
    <section id="finance">
        <div class="finance__inner">
            <div v-if="loading" class="loading">
                <font-awesome-icon icon="spinner" spin  size="lg"/>
            </div>
            <section v-else class="data">
                <article v-for="item in data" class="data__item data__item_type_regular">
                    <div>{{ item.email }}</div>
                    <div>{{ item.name }}</div>
                </article>
            </section>

            <form class="s-form" @submit.prevent="">
                <div class="s-form__inputs">
                    <input
                            class="finance__color-range"
                            type="range"
                            min="0"
                            max="10"
                            step="1"
                            v-model="fields.color.value"
                    >
                    <div class="finance__color" :style="colorStyle"></div>
                    <s-input
                            label="E-mail"
                            :required="true"
                            :icon="true"
                            :value="fields.email.value"
                            :pattern="emailPattern"
                            patternMessage="Введите корректный email"
                            @validate="onValidate_email"
                            @input="onInput_email"
                    />
                    <s-input
                            label="ФИО"
                            :required="true"
                            :icon="true"
                            :value="fields.name.value"
                            :pattern="/^[a-zA-Z ]+$/"
                            patternMessage="Только латинские буквы"
                            @validate="onValidate_name"
                            @input="onInput_name"
                    />
                </div>
            </form>
            <div class="s-form__buttons">
                <button
                        class="button s-form__button"
                        :class="buttonClass"
                        @click="onSubmit"
                >
                    Отправить
                </button>
            </div>
        </div>
    </section>
</template>

<script>
    import sInput from 'Components/common/SInput/SInput.vue'

    export default {
        created() {
            this.getData()
        },
        data() {
            return {
                fields: {
                    name: {
                        value: null,
                        isValid: null
                    },
                    email: {
                        value: null,
                        isValid: null
                    },
                    color: {
                        value: 5
                    }
                }
            }
        },
        computed: {
            data() {
                return this.$store.getters.data
            },
            loading() {
                return this.data === null
            },
            emailPattern() {
                return /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            },
            colorStyle() {
                let color;
                const value = this.fields.color.value;

                if (value < 4) {
                    color = 'green'
                } else if (value < 7) {
                    color = 'yellow'
                } else if (value < 9) {
                    color = 'red'
                } else {
                    color = 'black'
                }

                return {backgroundColor: color}
            },
            isComplete() {
                return this.fields.name.isValid
                    && this.fields.email.isValid
                    ;
                },
            buttonClass() {
                return this.isComplete ? 's-form__button_active' : '';
            },
        },
        methods: {
            getData() {
                this.$store.dispatch('getData');
            },
            onValidate_name({isValid, index}) {
                this.fields.name.isValid = isValid;
            },
            onInput_name({index, value}) {
                this.fields.name.value = value;
            },
            onValidate_email({isValid, index}) {
                this.fields.email.isValid = isValid;
            },
            onInput_email({index, value}) {
                this.fields.email.value = value;
            },
            onSubmit() {
                if (this.isComplete) {
                    this.$store.dispatch('saveData', {
                        color: this.fields.color.value,
                        email: this.fields.email.value,
                        name: this.fields.name.value,
                    })
                }
            },
        },
        components: {
            sInput
        }
    }
</script>

<style lang="stylus">
    .finance__inner
        max-width 400px
        margin 30px auto

    .finance__color-range
        display block
        margin 0 auto 6px

    .finance__color
        transition all .3s
        height 20px

    .s-form {
        margin 20px auto 0
        position relative
        .s-input, .s-select {
            box-sizing border-box
            display: flex;
            justify-content center
            margin 10px 0
            position relative
            .s-input__label, .s-select__label {
                flex-basis 25%
                text-align right
                margin-top 9px
            }
            .s-input__input-message, .s-select__input-message {
                box-sizing: border-box;
                flex-basis: 70%;
                max-width: 200px;
                padding: 0 10px;
                input, select {
                    box-sizing: border-box;
                    width: 100%;
                    padding: 7px 10px;
                    border: solid 1px #3f6b30;
                    border-radius: 5px;
                    font-size: 16px;
                    outline: none;
                }
                .s-input__hint {
                    font-size: 13px;
                    color: #888;
                }
                .s-input__message {
                    margin: 5px 0 20px;
                    font-size: 13px;
                    font-family: "Century Gothic";
                    color: #AF4925;
                }
                .s-select__message {
                    margin: 10px 0;
                    font-size: 13px;
                    font-family: "Century Gothic";
                    color: #333;
                }
            }
            .s-select__input-message {
                margin-right: 21px;
            }
            .s-input__icon-wrap {
                width: 21px;
                height: 21px;
                margin-top: 5px;
            }
        }
    }
    .s-form__buttons {
        margin-top: 30px;
        display: flex;
        justify-content: center
        .s-form__button {
            display: block;
            color: #888;
            transition: all .3s;
            margin: 0 20px;
            font-size 16px
            padding 12px 18px
            text-transform uppercase

            &.s-form__button_active {
                background: #639355;
                color: #fff;
                cursor: pointer;
            }
        }
        .s-form__cancel-button {
            background: #567f96;
            color: #fff;
            cursor: pointer;
        }
    }

    .button
        font-family "Century Gothic"
        text-align center
        border none
        border-radius 4px
        font-weight bold


    .loading
        position relative
        display flex
        justify-content center
        align-items center
        margin 40px auto
        color #555;

    .data__item_type_regular
        display flex
        justify-content space-around
        margin 6px 0

    .fade-enter-active {
        transition: all .3s;
    }
    .fade-leave-active {
        transition: all .3s;
    }
    .fade-enter, .fade-leave-to{
        opacity: 0;
    }
    .fade-move {
        transition: all .3s;
    }


    .fade-slide-enter-active {
        transition: all .3s;
    }
    .fade-slide-leave-active {
        transition: all .3s;
        position: absolute;
    }
    .fade-slide-enter, .fade-slide-leave-to{
        opacity: 0;
        transform: translateY(-20)
    }
    .fade-slide-move {
        transition: all .3s;
    }
</style>
