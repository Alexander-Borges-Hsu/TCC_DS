@extends('layouts.main')

@section('content')
<div class="container mt-5 sobre-nos-container">
    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1>Conheça a <span>VerdeCalc</span></h1>
            <p>Transformando dados em ações sustentáveis para empresas comprometidas com o futuro</p>
            <a href="#mission" class="btn">Saiba Mais</a>
        </div>
    </section>
    
    <!-- Mission Section -->
    <section id="mission" class="section mission-section sobre-nos-section fade-in">
        <div class="container">
            <div class="section-title">
                <h2>Nossa Missão</h2>
            </div>
            <div class="mission-content">
                <div class="mission-text">
                    <p>A VerdeCalc nasceu da visão de seis estudantes entusiastas em tecnologias web e desenvolvimento de aplicações, que identificaram um tema de grande relevância, porém pouco abordado: o impacto ambiental das emissões de CO₂ no setor empresarial.</p>
                    <p>Percebemos que, apesar da crescente preocupação com sustentabilidade, muitas empresas ainda carecem de ferramentas acessíveis e eficientes para mensurar e gerenciar suas emissões de carbono. Nossa missão é preencher essa lacuna, oferecendo uma solução tecnológica que permite às organizações de todos os portes calcular, monitorar e reduzir sua pegada de carbono.</p>
                    <p>Acreditamos que a transformação ambiental começa com dados precisos e ações concretas. Por isso, desenvolvemos uma plataforma que não apenas quantifica as emissões, mas também orienta as empresas em sua jornada rumo à sustentabilidade.</p>
                </div>
                <div class="mission-image">
                    <img src="https://images.unsplash.com/photo-1623000850756-f41458ab7d3c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Missão VerdeCalc">
                </div>
            </div>
            
            <div class="values-container">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="value-text">
                        <h4>Sustentabilidade</h4>
                        <p>Promovemos práticas empresariais que respeitam os limites do planeta e contribuem para um futuro mais sustentável.</p>
                    </div>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="value-text">
                        <h4>Precisão</h4>
                        <p>Oferecemos dados confiáveis e análises precisas para embasar decisões estratégicas nas empresas.</p>
                    </div>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="value-text">
                        <h4>Inovação</h4>
                        <p>Buscamos constantemente soluções inovadoras para os desafios ambientais enfrentados pelo setor empresarial.</p>
                    </div>
                </div>
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div class="value-text">
                        <h4>Acessibilidade</h4>
                        <p>Democratizamos o acesso a ferramentas de gestão ambiental para empresas de todos os portes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Impact Section -->
    <section class="section impact-section sobre-nos-section fade-in">
        <div class="container">
            <div class="section-title">
                <h2>Nosso Impacto</h2>
            </div>
            <p class="text-center">A VerdeCalc está transformando a maneira como as empresas abordam a sustentabilidade, proporcionando resultados mensuráveis:</p>
            
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">85%</div>
                    <div class="stat-text">das empresas que utilizam nossa plataforma conseguem reduzir suas emissões de CO₂ em até 30% no primeiro ano</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">62%</div>
                    <div class="stat-text">das organizações reportam economia financeira significativa após implementar as recomendações da VerdeCalc</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">90%</div>
                    <div class="stat-text">dos usuários corporativos consideram nossa plataforma essencial para suas estratégias de sustentabilidade</div>
                </div>
            </div>
            
            <p class="text-center">Estes números refletem nosso compromisso em fornecer soluções eficazes que beneficiam tanto as empresas quanto o meio ambiente.</p>
        </div>
    </section>
    
    <!-- Team Section -->
    <section class="section sobre-nos-section fade-in">
        <div class="container">
            <div class="section-title">
                <h2>Nossa Equipe</h2>
            </div>
            <p class="text-center">Conheça os entusiastas que tornaram a VerdeCalc possível:</p>
            
            <div class="text-center mb-5">
                <img src="https://via.placeholder.com/600x400?text=Equipe+VerdeCalc" alt="Equipe VerdeCalc" class="team-photo">
            </div>
            
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="team-info text-center">
                        <h3 class="mb-4">Desenvolvedores e Pesquisadores</h3>
                        <p class="mb-4">Nossa equipe é formada por seis estudantes entusiastas em tecnologias web e desenvolvimento de aplicações, cada um contribuindo com habilidades específicas para tornar a VerdeCalc uma realidade:</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-4 mb-4">
                                <h4>Alexander</h4>
                                <p>Desenvolvedor Back-end</p>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h4>Carlos</h4>
                                <p>Desenvolvedor Front-end</p>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h4>Davi</h4>
                                <p>Desenvolvedor Full-stack</p>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h4>Diego</h4>
                                <p>Desenvolvedor Front-end</p>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h4>Kauã</h4>
                                <p>Analista de Sistemas</p>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h4>Gustavo</h4>
                                <p>Pesquisador</p>
                            </div>
                        </div>
                        
                        <p>Juntos, combinamos nossas habilidades em desenvolvimento web, análise de sistemas e pesquisa para criar uma solução inovadora que ajuda empresas a monitorar e reduzir suas emissões de carbono.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="section features-section sobre-nos-section fade-in">
        <div class="container">
            <div class="section-title">
                <h2>Nossos Diferenciais</h2>
            </div>
            <p class="text-center">A VerdeCalc oferece uma solução completa para empresas que desejam gerenciar suas emissões de carbono:</p>
            
            <div class="features-container">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="feature-title">Cálculo Preciso</h3>
                    <p>Nossa calculadora utiliza metodologias reconhecidas internacionalmente para estimar as emissões de CO₂ da sua empresa com precisão.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="feature-title">Análise Detalhada</h3>
                    <p>Fornecemos relatórios detalhados que identificam as principais fontes de emissão e oportunidades de redução em sua operação.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="feature-title">Recomendações Personalizadas</h3>
                    <p>Com base nos seus dados, oferecemos sugestões práticas e viáveis para reduzir as emissões de carbono da sua empresa.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3 class="feature-title">Certificação</h3>
                    <p>Empresas que atingem metas de redução podem receber certificados digitais para demonstrar seu compromisso com a sustentabilidade.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Comunidade</h3>
                    <p>Acesso a uma rede de empresas comprometidas com a sustentabilidade, facilitando a troca de experiências e melhores práticas.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="feature-title">Recursos Educativos</h3>
                    <p>Biblioteca de conteúdos sobre sustentabilidade empresarial, legislação ambiental e tendências do mercado.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="section cta-section sobre-nos-section fade-in">
        <div class="container">
            <div class="cta-content">
                <h2>Pronto para transformar sua empresa?</h2>
                <p>Junte-se a centenas de organizações que já estão utilizando a VerdeCalc para medir, gerenciar e reduzir suas emissões de carbono. Nossa plataforma foi desenvolvida especialmente para atender às necessidades das empresas brasileiras.</p>
                <div class="cta-buttons">
                    <a href="/navegar/formularioUm" class="btn">Comece Agora</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sobre_nos.css') }}">
<link rel="stylesheet" href="{{ asset('css/sobre_nos_nav.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/sobre_nos.js') }}"></script>
@endpush
