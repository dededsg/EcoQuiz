from django.shortcuts import render, redirect
import random
def login_view(request):
    # Aqui, você pode redirecionar diretamente para o "ranking" ou "jogar"
    # Vamos redirecionar para "/ranking/" após o "login" (sem verificação)
    return redirect('ranking')  # Ou 'jogar', dependendo de sua escolha

def ranking(request):
    return render(request, 'quiz/ranking.html')  # Template para a página de ranking

def jogar(request):
    return render(request, 'quiz/jogar.html')  # Template para a página de jogar

def ranking(request):
    # Dados de exemplo para o ranking
    ranking_data = [
        {"posicao": 1, "nome": "João", "pontos": 100, "medalha": "ouro.png"},
        {"posicao": 2, "nome": "Maria", "pontos": 90, "medalha": "prata.png"},
        {"posicao": 3, "nome": "José", "pontos": 80, "medalha": "bronze.png"},
        {"posicao": 4, "nome": "Ana", "pontos": 70, "medalha": ""},
    ]

    return render(request, 'quiz/ranking.html', {'ranking_data': ranking_data})

def questao(request):
    # Array de questões simuladas
    questoes = [
        {
            'enunciado': 'Qual a capital do Brasil?',
            'q1': 'São Paulo',
            'q2': 'Brasília',
            'q3': 'Rio de Janeiro',
            'q4': 'Salvador',
            'resposta': 2,  # Índice da resposta correta (2 = Brasília)
            'explicacao': 'Brasília é a capital do Brasil desde 1960.'
        },
        {
            'enunciado': 'Qual a maior montanha do mundo?',
            'q1': 'Monte Fuji',
            'q2': 'Monte Everest',
            'q3': 'K2',
            'q4': 'Kangchenjunga',
            'resposta': 2,  # Resposta correta é o Monte Everest
            'explicacao': 'O Monte Everest é o ponto mais alto da Terra.'
        },
        # Adicione mais questões conforme necessário
    ]

    # Seleciona uma questão aleatória
    questao_aleatoria = random.choice(questoes)

    return render(request, 'questao.html', {'questao': questao_aleatoria})



def verifica_questao(request):
    resposta_usuario = int(request.POST.get('quiz'))
    resposta_correta = int(request.POST.get('resposta'))
    explicacao = request.POST.get('explicacao')

    if resposta_usuario == resposta_correta:
        resultado = "Correto!"
    else:
        resultado = "Errado!"

    return render(request, 'resultado.html', {
        'resultado': resultado,
        'explicacao': explicacao
    })
    
