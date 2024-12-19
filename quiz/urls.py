from django.urls import path
from . import views

urlpatterns = [
    path('', views.login_view, name='login'),
    path('login/', views.login_view, name='login'),
    path('logout/', views.logout_view, name='logout'),
    path('questao/', views.questao_view, name='quiz'),
    path('resultado/', views.resultado_view, name='resultado'),
    path('ranking/', views.ranking_view, name='ranking'),
]
