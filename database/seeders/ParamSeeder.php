<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $texto = "O cadastro para esterilização de cães e gatos deverá ser feito mediante preenchimento e envio deste formulário eletrônico. As solicitações serão avaliadas pela equipe responsável e, se aceitas, o solicitante deverá aguardar o contato da equipe do CCZ para agendamento. O prazo de espera poderá variar de acordo com a demanda. Cabe ao solicitante acompanhar o andamento de sua solicitação no site.

        Critérios quanto ao solicitante 
        O solicitante deve ser maior de 18 anos e residir no município de Contagem/MG.
        Cada solicitante tem direito de cadastrar o limite máximo de 3 (três) animais, sendo que à medida em que as cirurgias forem realizadas, novas vagas serão disponibilizadas para cadastramento;
        É de inteira responsabilidade do solicitante informar corretamente 1 (um) ou 2 (dois) contatos telefônicos.
        A cada solicitação é gerado um número de cadastro para controle interno, não correspondendo à ordem de atendimento ou agendamento.
        As solicitações passam por uma triagem, podendo ser aprovadas ou não. É de responsabilidade do solicitante acompanhar o andamento da sua solicitação pelo site.
        Após a aprovação do cadastro, o solicitante deverá aguardar o contato telefônico do CCZ, de segunda a sexta-feira, em horário comercial, para fins de agendamento. Após 2 (duas) tentativas de contato sem sucesso, o cadastro será cancelado, podendo o solicitante realizar novo cadastro quando desejar.
        No dia agendado para a cirurgia de esterilização, é obrigatória a apresentação de documento de identidade com foto e comprovante de residência (IPTU, CEMIG, COPASA) em seu nome. Em caso de impossibilidade de comparecimento no dia agendado, o solicitante poderá designar um representante através de declaração escrita e assinada a ser apresentada ao CCZ juntamente com os documentos supracitados, bem como um documento de identificação do representante;
        Caso o solicitante possua Carteira Nacional de Saúde (CNS), que pode ser emitida em qualquer unidade de saúde, ou benefício do governo, é obrigatória a apresentação de documentação comprobatória no dia agendado para a cirurgia.
        No dia agendado para a cirurgia de esterilização o solicitante deve chegar com 30 minutos de antecedência, sob pena de ter o atendimento cancelado.
        No dia agendado para a cirurgia, o solicitante deve levar:
        No caso de cadela ou gata: cobertor, atadura crepom (faixa) nova e colar elisabetano ou macacão cirúrgico;
        No caso de cão: cobertor e colar elisabetano;
        No caso de gato: cobertor.
        Importante: Cães e cadelas devem ser conduzidos em guias próprias. Nunca soltos. Felinos devem ser transportados em caixas de transporte próprias, nunca no colo ou em guias, devido ao risco de fugas.
        Em caso de ausência no dia agendado, sem aviso prévio, a solicitação será cancelada e o interessado só terá direito a realizar novo processo de cadastramento para cirurgia de esterilização do animal decorridos 6 (seis) meses contados a partir da data agendada.
        Excepcionalmente, o CCZ poderá cancelar cirurgias agendadas, ocasião em que o solicitante será comunicado por telefone com até 24 horas de antecedência e o procedimento será remarcado.
        A cirurgia de esterilização só será realizada mediante leitura, preenchimento e assinatura pelo solicitante do Termo de Autorização para Realização de Cirurgia.
        Critérios quanto aos cães e gatos
        Para serem submetidos à esterilização, os animais devem ter no mínimo 6 (seis) meses e no máximo 8 (oito) anos. O CCZ não realiza esterilização em animais idosos.
        O CCZ não realiza esterilização em animais com lesões cutâneas, epilépticos, obesos, no cio (cadelas) ou em gestação avançada (gatas ou cadelas). Se a cadela estiver no cio, deve-se aguardar pelo menos 20 dias após o término do mesmo para realizar a esterilização. Em caso de gestação (gatas ou cadelas) recente, deve-se aguardar pelo menos 60 dias após o parto para realizar a esterilização.
        Antes da cirurgia de esterilização, os animais poderão ser submetidos a exame clínico pelo médico veterinário do CCZ, podendo ser considerados inaptos para a cirurgia, caso sejam constatadas quaisquer alterações consideradas significativas e que impossibilitem a realização da cirurgia.
        No caso de caninos, o solicitante pode apresentar exame recente (menos de 6 meses) de leishmaniose ou submeter o animal, no CCZ, ao teste rápido para Leishmaniose Visceral no dia agendado. Em caso de resultado negativo a cirurgia poderá ser realizada imediatamente. Em caso de resultado positivo, a cirurgia não poderá ser realizada imediatamente e o solicitante deverá aguardar o resultado do exame sorológico ELISA confirmatório para Leishmaniose Visceral.
        Só serão esterilizados animais com exame positivo para Leishmaniose visceral ou que estejam em tratamento veterinário de qualquer tipo, mediante laudo de médico veterinário responsável pelo tratamento, autorizando a cirurgia de esterilização.
        O CCZ não realiza exames de risco cirúrgico, sendo altamente recomendado que o solicitante o faça por conta própria.
        Cães e gatos comunitários ou abandonados recolhidos pelo CCZ são atendidos prioritariamente, assim como cães e gatos pertencentes a imóveis ou regiões do município onde seja constatada a necessidade de atendimento imediato, em face da superpopulação de animais, alto risco epidemiológico, calamidades e/ou outros casos específicos mediante avaliação do corpo técnico do CCZ.
        Cães e gatos comunitários ou abandonados recolhidos por organizações da sociedade civil poderão ser atendidos segundo critérios específicos, objetivando a cooperação mútua, controle populacional ético, guarda responsável e/ou adoção dos animais, mediante celebração de convênios.
        No dia do procedimento o solicitante deverá assinar um termo de autorização que pode ser acessado nesse link.";
        DB::table('params')->insert(['id' => '1', 'value' => 'Versão 2.0']);
        DB::table('params')->insert(['id' => '2', 'value' => $texto]);
    }
}
