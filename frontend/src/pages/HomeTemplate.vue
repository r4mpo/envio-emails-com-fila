<template>
    <div class="container-fluid px-5 my-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card border-0 rounded-3 shadow-lg overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-6 d-none d-sm-block bg-image">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nome do destinatário</th>
                                            <th scope="col">E-mail do destinatário</th>
                                            <th scope="col">Data/Hora de criação do registro</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="email in emails" v-bind:key="email.id">
                                            <th scope="row">{{ email.dados.nome_destinatario }}</th>
                                            <td>{{ email.dados.email_destinatario }}</td>
                                            <td>{{ email.data_hora }}</td>
                                            <td>{{ email.status }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6 p-4">
                                <div class="text-center">
                                    <div class="h3 fw-light">ENVIAR NOVO E-MAIL</div>
                                    <p class="mb-4 text-muted">Envie uma mensagem de contato</p>
                                </div>

                                <form id="contactForm" data-sb-form-api-token="API_TOKEN" onsubmit="return false;">
                                    <!-- Name Input -->
                                    <div class="form-floating mb-3">
                                        <input v-model="email.nome_destinatario" class="form-control" id="name"
                                            type="text" placeholder="Nome" data-sb-validations="required" />
                                        <label for="name">Nome Destinatário</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">O campo de nome é
                                            obrigatório
                                        </div>
                                    </div>

                                    <!-- Email Input -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" v-model="email.email_destinatario" id="emailAddress"
                                            type="email" placeholder="Email Address"
                                            data-sb-validations="required,email" />
                                        <label for="emailAddress">Email Destinatário</label>
                                        <div class="invalid-feedback" data-sb-feedback="emailAddress:required">O campo
                                            de e-mail é obrigatório</div>
                                        <div class="invalid-feedback" data-sb-feedback="emailAddress:email">O campo de
                                            e-mail precisa estar válido</div>
                                    </div>

                                    <!-- Assunto -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" v-model="email.assunto_email" id="subject"
                                            type="text" placeholder="Assunto" data-sb-validations="required" />
                                        <label for="subject">Assunto e-mail</label>
                                        <div class="invalid-feedback" data-sb-feedback="subject:required">O campo de
                                            assunto do e-mail é obrigatório
                                        </div>
                                    </div>

                                    <!-- Message Input -->
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" v-model="email.corpo_email" id="message"
                                            type="text" placeholder="Message" style="height: 10rem;"
                                            data-sb-validations="required"></textarea>
                                        <label for="message">Corpo do E-mail</label>
                                        <div class="invalid-feedback" data-sb-feedback="message:required">O corpo do
                                            e-mail é obrigatório</div>
                                    </div>

                                    <div id="submitSuccessMessage" class="alert alert-success" style="display: none;">
                                        E-mail enviado com sucesso!
                                    </div>

                                    <div id="submitErrorMessage" class="alert alert-danger" style="display: none;">
                                        Ocorreu um erro ao enviar o e-mail. Tente novamente.
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit"
                                            :disabled="!isFormValid" v-on:click="postEmails()">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getData, postData } from "../Operations";

export default {
    name: 'HomeTemplate',
    data() {
        return {
            emails: [],
            email: {
                nome_destinatario: '',
                email_destinatario: '',
                assunto_email: '',
                corpo_email: '',
            },
        }
    },
    mounted(){
        this.getEmails();
    },
    computed: {
        // Método computado para verificar se o formulário está válido
        isFormValid() {
            // Verificar se todos os campos estão preenchidos corretamente
            return this.email.nome_destinatario &&
                this.email.email_destinatario &&
                this.email.assunto_email &&
                this.email.corpo_email &&
                this.isValidEmail(this.email.email_destinatario);
        }
    },
    methods: {
        // Método para validar o formato do e-mail
        isValidEmail(email) {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailPattern.test(email);
        },

        async getEmails() {
            let url = 'emails/recuperar';

            try {
                let search = await getData(url);
                this.emails = search.dados;
            } catch (error) {
                alert('houve um erro inesperado');
            }
        },

        async postEmails() {
            try {
                let url = 'emails/enviar';
                let create = await postData(url, this.email);

                if (create.cod == undefined || create.cod != 111) {
                    // Exibir a mensagem de erro
                    document.getElementById('submitErrorMessage').style.display = 'block';
                    // Ocultar a mensagem após 3 segundos
                    setTimeout(() => {
                        document.getElementById('submitErrorMessage').style.display = 'none';
                    }, 3000);
                    alert(create.message); // Caso queira alertar também
                } else {
                    // Caso de sucesso, exibe a mensagem de sucesso
                    document.getElementById('submitSuccessMessage').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('submitSuccessMessage').style.display = 'none';
                    }, 3000);
                }

                // Limpar os campos do formulário
                this.email.nome_destinatario = '';
                this.email.email_destinatario = '';
                this.email.assunto_email = '';
                this.email.corpo_email = '';

                document.getElementById('name').disabled = false;
                document.getElementById('emailAddress').disabled = false;
                document.getElementById('subject').disabled = false;
                document.getElementById('message').disabled = false;


                // Recarregar a lista de e-mails
                this.getEmails();
                
            } catch (error) {
                // Caso ocorra algum erro no envio
                document.getElementById('submitErrorMessage').style.display = 'block';
                setTimeout(() => {
                    document.getElementById('submitErrorMessage').style.display = 'none';
                }, 3000);
                alert('Houve um erro inesperado ao tentar enviar o e-mail. Tente novamente.');
            }
        }
    }
}
</script>

<style>
body {
    background: #007bff;
    background: linear-gradient(to right, #0062E6, #33AEFF);
}

.bg-image {
    background-image: url('https://source.unsplash.com/kKvQJ6rK6S4/660x1000');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
