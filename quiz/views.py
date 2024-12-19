from django.shortcuts import render, redirect
import random
def login_view(request):
    return redirect('ranking')

def ranking(request):
    return render(request, 'quiz/ranking.html') 
def jogar(request):
    return render(request, 'quiz/jogar.html') 

def ranking(request):
    ranking_data = [
        {"posicao": 1, "nome": "Develin Souza Gonçalves", "pontos": 5, "medalha": "ouro.png"},
        {"posicao": 2, "nome": "Luís Antonio Scarabelot Fiabani", "pontos": 4, "medalha": "prata.png"},
        {"posicao": 3, "nome": "Artur Manarin de Jesus", "pontos": 3, "medalha": "bronze.png"},
        {"posicao": 4, "nome": "Diva Moreira de Souza", "pontos": 3, "medalha": ""},
        {"posicao": 5, "nome": "Arthur Bauer Cardoso", "pontos": 2, "medalha": ""},
        {"posicao": 6, "nome": "Marina Carradore Sérgio", "pontos": 1, "medalha": ""},
    ]

    return render(request, 'quiz/ranking.html', {'ranking_data': ranking_data})

def questao(request):
    questoes = [
        {
            'enunciado': 'O que é o "aquecimento global"?',
            'q1': 'Aumento da quantidade de gases de efeito estufa na atmosfera',
            'q2': 'O aumento da temperatura média global devido ao acúmulo de gases efeito estufa',
            'q3': 'Mudanças na direção dos ventos devido à poluição',
            'q4': 'Resfriamento global causado pela atividade solar',
            'resposta': 2,
            'explicacao': 'O aquecimento global refere-se ao aumento da temperatura média global devido ao acúmulo de gases efeito estufa na atmosfera.'
        },

    ]
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
    
