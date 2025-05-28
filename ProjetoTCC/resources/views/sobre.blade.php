@extends('layouts.main')

@section('content')
<div class="container mt-5 sobre-nos-container">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="titulo-sobre-nos">Sobre Nós</h1>
            <div class="linha-decorativa"></div>
        </div>
    </div>

    <div class="row mb-5 align-items-center sobre-nos-section fade-in">
        <div class="col-md-6">
            <h2 class="subtitulo-sobre-nos">Nossa Missão</h2>
            <p class="texto-sobre-nos">
                O VerdeCalc nasceu da necessidade de tornar o monitoramento de emissões de carbono acessível e prático para empresas de todos os portes. Nossa missão é capacitar organizações a entenderem, medirem e reduzirem seu impacto ambiental através de ferramentas intuitivas e baseadas em dados científicos.
            </p>
            <p class="texto-sobre-nos">
                Acreditamos que a transparência e a precisão nas medições de carbono são fundamentais para um futuro sustentável. Por isso, desenvolvemos uma plataforma que combina facilidade de uso com rigor técnico, permitindo que empresas tomem decisões informadas sobre suas estratégias ambientais.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <div class="icone-missao">
                <i class="fas fa-leaf fa-5x"></i>
            </div>
        </div>
    </div>

    <div class="row mb-5 align-items-center sobre-nos-section fade-in">
        <div class="col-md-6 text-center order-md-1 order-2">
            <div class="icone-valores">
                <i class="fas fa-globe-americas fa-5x"></i>
            </div>
        </div>
        <div class="col-md-6 order-md-2 order-1">
            <h2 class="subtitulo-sobre-nos">Nossos Valores</h2>
            <ul class="lista-valores">
                <li><strong>Sustentabilidade:</strong> Comprometimento com práticas ambientalmente responsáveis em tudo o que fazemos.</li>
                <li><strong>Inovação:</strong> Busca constante por soluções tecnológicas que facilitem a transição para uma economia de baixo carbono.</li>
                <li><strong>Transparência:</strong> Compromisso com dados precisos e metodologias claras em nossas análises.</li>
                <li><strong>Acessibilidade:</strong> Democratização do acesso a ferramentas de gestão ambiental para empresas de todos os tamanhos.</li>
                <li><strong>Impacto Positivo:</strong> Foco em gerar mudanças reais e mensuráveis para um planeta mais saudável.</li>
            </ul>
        </div>
    </div>

    <div class="row mb-5 sobre-nos-section fade-in">
        <div class="col-12">
            <h2 class="subtitulo-sobre-nos text-center">Nossa Tecnologia</h2>
            <div class="linha-decorativa mb-4"></div>
            <p class="texto-sobre-nos">
                O VerdeCalc utiliza algoritmos avançados baseados nas metodologias do GHG Protocol e IPCC (Painel Intergovernamental sobre Mudanças Climáticas) para calcular emissões de carbono com precisão. Nossa plataforma considera múltiplas fontes de emissão, incluindo:
            </p>
            <div class="row mt-4 tecnologia-cards">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card card-tecnologia">
                        <div class="card-body text-center">
                            <i class="fas fa-car fa-3x mb-3"></i>
                            <h5 class="card-title">Transporte</h5>
                            <p class="card-text">Cálculos precisos baseados em tipo de combustível, distância e eficiência.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card card-tecnologia">
                        <div class="card-body text-center">
                            <i class="fas fa-bolt fa-3x mb-3"></i>
                            <h5 class="card-title">Energia</h5>
                            <p class="card-text">Análise de consumo elétrico considerando a matriz energética local.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card card-tecnologia">
                        <div class="card-body text-center">
                            <i class="fas fa-industry fa-3x mb-3"></i>
                            <h5 class="card-title">Produção</h5>
                            <p class="card-text">Métricas específicas para diferentes setores industriais e processos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card card-tecnologia">
                        <div class="card-body text-center">
                            <i class="fas fa-trash fa-3x mb-3"></i>
                            <h5 class="card-title">Resíduos</h5>
                            <p class="card-text">Cálculos de emissões baseados em volume e tipo de resíduos gerados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 sobre-nos-section fade-in">
        <div class="col-12 text-center">
            <h2 class="subtitulo-sobre-nos">Nossa Equipe</h2>
            <div class="linha-decorativa mb-4"></div>
            <p class="texto-sobre-nos mb-5">
                Somos uma equipe multidisciplinar de engenheiros ambientais, desenvolvedores de software e especialistas em sustentabilidade, unidos pela paixão de criar soluções tecnológicas para os desafios ambientais do nosso tempo.
            </p>
            <div class="row justify-content-center equipe-cards">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card card-equipe">
                        <div class="card-body text-center">
                            <div class="avatar-placeholder">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                            <h5 class="card-title mt-3">Equipe de Desenvolvimento</h5>
                            <p class="card-text">Responsável pela arquitetura e implementação da plataforma VerdeCalc, garantindo uma experiência intuitiva e eficiente.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card card-equipe">
                        <div class="card-body text-center">
                            <div class="avatar-placeholder">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                            <h5 class="card-title mt-3">Especialistas Ambientais</h5>
                            <p class="card-text">Garantem a precisão científica dos cálculos e a conformidade com as metodologias internacionais de contabilização de carbono.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card card-equipe">
                        <div class="card-body text-center">
                            <div class="avatar-placeholder">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                            <h5 class="card-title mt-3">Consultores de Sustentabilidade</h5>
                            <p class="card-text">Fornecem insights estratégicos e recomendações personalizadas para ajudar empresas a reduzirem suas emissões.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 sobre-nos-section fade-in">
        <div class="col-12 text-center">
            <h2 class="subtitulo-sobre-nos">Contato</h2>
            <div class="linha-decorativa mb-4"></div>
            <p class="texto-sobre-nos">
                Estamos sempre abertos a feedback, parcerias e novas ideias. Entre em contato conosco:
            </p>
            <div class="contato-info mt-4">
                <p><i class="fas fa-envelope"></i> contato@verdecalc.com.br</p>
                <p><i class="fas fa-phone"></i> (11) 5555-1234</p>
                <p><i class="fas fa-map-marker-alt"></i> Av. Paulista, 1000 - São Paulo, SP</p>
            </div>
            <div class="social-icons mt-4">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .sobre-nos-container {
        padding-bottom: 50px;
    }
    
    .titulo-sobre-nos {
        color: var(--color-primary, #3b82f6);
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .subtitulo-sobre-nos {
        color: var(--color-secondary, #10b981);
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    .texto-sobre-nos {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--color-text, #374151);
    }
    
    .linha-decorativa {
        height: 4px;
        width: 80px;
        background: linear-gradient(90deg, var(--color-primary, #3b82f6), var(--color-secondary, #10b981));
        margin: 0 auto 2rem;
        border-radius: 2px;
    }
    
    .sobre-nos-section {
        margin-bottom: 4rem;
        padding: 2rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .sobre-nos-section:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .icone-missao, .icone-valores {
        color: var(--color-primary, #3b82f6);
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease;
    }
    
    .icone-missao:hover, .icone-valores:hover {
        transform: scale(1.1);
    }
    
    .lista-valores {
        list-style-type: none;
        padding-left: 0;
    }
    
    .lista-valores li {
        padding: 0.8rem 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 1.1rem;
    }
    
    .lista-valores li:last-child {
        border-bottom: none;
    }
    
    .card-tecnologia, .card-equipe {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    
    .card-tecnologia:hover, .card-equipe:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    .card-tecnologia i {
        color: var(--color-primary, #3b82f6);
    }
    
    .avatar-placeholder {
        width: 80px;
        height: 80px;
        background-color: #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #9ca3af;
    }
    
    .contato-info p {
        font-size: 1.1rem;
        margin-bottom: 0.8rem;
    }
    
    .contato-info i {
        color: var(--color-primary, #3b82f6);
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
    
    .social-icons {
        display: flex;
        justify-content: center;
        gap: 20px;
    }
    
    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--color-primary, #3b82f6);
        color: white;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    
    .social-icon:hover {
        transform: scale(1.1);
        background-color: var(--color-secondary, #10b981);
        color: white;
    }
    
    /* Animações */
    .fade-in {
        animation: fadeIn 1s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .titulo-sobre-nos {
            font-size: 2rem;
        }
        
        .subtitulo-sobre-nos {
            font-size: 1.5rem;
        }
        
        .sobre-nos-section {
            padding: 1.5rem;
        }
    }
</style>
@endpush
