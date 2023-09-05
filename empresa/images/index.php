<?php
        /*if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
            // Get the current URL and protocol
            $redirect = 'https://' . $_SERVER['HTTP_HOST'];
        
        
            // Redirect to the HTTPS version of the page
            echo'<script>window.location = "'.$redirect.'"</script>';
        }*/
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <title>SER en Acción</title>
</head>

<body>
    <header>
        <div class="container">
            <nav class="main-nav">
                <img src="images/SerEnAcc.svg" alt="SER en Acción" class="logo">

                <ul class="main-menu" style="font-size: 17px; font-weight: 500;">
                    <li><a href="index.html" style="color:#1453a0;">Inicio</a></li>
                    <li><a href="/empresa/candidatos.html" style="color:#1453a0;">Candidatos</a></li>
                    <li><a href="#" style="color:#1453a0;">Organizaciones</a></li>
                </ul>
                <ul class="right-menu">
                <?php
                if(isset($_COOKIE['tipo']) && isset($perfil['id_'.$_COOKIE['tipo']])){
                    echo'
                    <li><a a href="'.$_COOKIE['tipo'].'/perfil.php"><button>Volver al Perfil</button></a></li>';
                }else{
                    echo'<li><a a href="login.php"><button>Iniciar sesión</button></a></li>';
                }
            ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="containerbg">
        <section class="banner dark">
            <div class="content-full">
                <h2>SER en Acción</h2>
                <p>La valoración del potencial para una empresa más exitosa</p>
                <div class="button"><button>Conoce más</button></div>
            </div>
        </section>
    </div>
    <div class="container">
        <section class="section1 dark">
            <div class="content-center">
                <h2>Te acompañamos en:</h2>
                <br>
                <div class="cards">
                    <div>
                        <h4>La búsqueda del trabajo deseado acorde a tu potencial y funciones de mayor gusto.</h4>
                    </div>
                    <div>
                        <h4>La selección de candidatos que saben hacer y tienen el potencial que requieres.</h4>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <h2 style="color:#1453a0">LOS NUEVOS ESCENARIOS DE MERCADO, LA TRANSFORMACIÓN DIGITAL Y LOS INTERESES
                ORGANIZACIONALES DE LOS EMPLEADOS, REQUIEREN EL RECONOCIMIENTO DEL POTENCIAL DEL SER HUMANO. ESTE NO
                PODRÁ SER REEMPLAZABLE CON TECNOLOGÍA.
            </h2>
        </section>
        <section class="ods light">
            <div class="content">
                <h2>SER EN ACCIÓN te ayuda a ser una compañía</h2>
                <h2>que actua entorno a la sostenibilidad laboral productiva un mejor mañana</h2>
                <h3>Contribuyendo positivamente al ser humano, a la sociedad y a la economía. Objetivo de Desarrollo
                    Sostenible No 5 (Equidad de Género), No 8 (Trabajo Decente) y No 10
                    (Disminución de desigualdades).</h3>
            </div>
        </section>
        <section>
            <h2 style="color:#1453a0;
            text-align: center; padding-top:30px;">TESTIMONIOS.
            </h2>
        </section>
        <section class="home-cards">
            <div>
                <img src="images/testimonial2.jpg" alt="">
                <h3>Paola Rivera - Candidata</h3>
                <p>
                    "Quiero compartir mi feliz y satisfactoria experiencia con SER EN ACCIÓN, cuyo registro de hoja de
                    vida me ayudó a ser reconocida por mi potencial y competencias. Ahora, sentirme valorada y apreciada
                    en mi trabajo me ha dado seguridad y motivación en mi carrera. Agradezco a SER EN ACCIÓN por su
                    apoyo en el logro de mis metas y la potencialización de mis habilidades."
                </p>
            </div>
            <div>
                <img src="images/testimonial1.jpg" alt="" />
                <h3>Luis Alejandro Camargo - Empresario</h3>
                <p>
                    “En algún momento pensamos que las cualificaciones académicas era el factor clave para atender las
                    necesidades de reclutamiento pero nos hemos dado cuenta que no garantiza el saber hacer ni la
                    experiencia. Ser en acción nos lleva a reconocer las competencias con el talento para cumplir con la
                    misión del cargo”
                </p>
            </div>
            <div>
                <img src="images/testimonial3.jpg" alt="" />
                <h3>Catalina Patiño - Candidata</h3>
                <p>
                    “Por fin puedo ser reconocida por mis capacidades, por fin puedo tener la oportunidad de mostrar mi
                    hoja de vida desde mis potenciales y lo que me gusta hacer, además puedo decir el tipo de compañía
                    en la que me gustaría trabajar. Así consegiré el trabajo donde estaré realmente cómoda y creciendo
                    profesionalmente”
                </p>
            </div>
        </section>

    </div>
    <!-- Links -->
    <section class="links">
        <div class="links-inner">
            <div class="logo_footer">
                <img src="images/SerEnAcc.svg">
                <p>SER en Acción moldea el proceso de reclutamiento hacia la satisfacción de necesidades de la
                    organización
                    y de los candidatos, moldeando con un nuevo paradigma de contratación.</p>
                <div class="follow">
                    <a href="www.instagram.com/serenaccion.com.co">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/serenaccion.com.co">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://twitter.com/serenaccion">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/serenaccion">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/serenaccion">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
            <div>
            </div>
            <ul>
                <li>
                    <h3>Conoce el modelo</h3>
                </li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Webinar</a></li>
                <li><a href="#">Documentación</a></li>
                <li><a href="#">Quiero ser parte</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Nuestros Aliados</h3>
                </li>
                <li><a href="#">Equipo SER</a></li>
                <li><a href="#">Sus servicios</a></li>
                <li><a href="#">Aliados</a></li>
                <li><a href="#">Otras actividades</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Sobre</h3>
                </li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="#">Misión / Visión</a></li>
                <li><a href="https://serenaccion.com.co/Term_Cond.html">Terminos y condiciones</a></li>
                <li><a href="#">Política de Retracto</a></li>
                <li><a href="https://serenaccion.com.co/Pol_trat_dat.html">Política de Tratamientos de datos</a></li>
            </ul>
        </div>
    </section>
    </div>
    <div class="overlay">
        <div class="popup">
            <div class="serenacc">
                <div class="circle"></div>
                <div class="descript">
                    <div class="textBox">
                        <h1>Haz parte del modelo de<br><span>Reclutamiento Sostenible</span> en la ERA DIGITAL</h1>
                        <h2 id="circle02" hidden>haz parte del modelo de<br><span>Reclutamiento Sostenible</span><br> en
                            la ERA DIGITAL</h2>
                        <p class="intro">Uniendo el éxito empresarial con el potencial de los candidatos: SER en Acción,
                            la plataforma de reclutamiento sostenible</p>
                        <button href="#" id="info" hidden>Conoce más</button>
                    </div>
                    <div class="imgBox" onmouseover="blurEffect()" onmouseleave="unblurEffect()">
                        <img src="../images/SER.svg" class="serenaccion">
                        <div class="contentBox">
                            <h2 id="contentBox-title" style="--i:1">Tu Experiencia en SER en ACCIÓN:</h2>
                            <p id="contentBox-text" style="--i:2">SER en Acción es un conector de relaciones productivas
                                sanas, generando experiencias potenciales para la organización y para el candidato,
                                haciendo sostenible la relación laboral al reconocer su potencial humano y su efecto en
                                la productividad de la organización bajo el efecto económico y su impacto social. </p>
                        </div>
                    </div>
                </div>

                <ul class="thumb">
                    Conoce los pilares del modelo de reclutamiento sostenible SER en Acción.
                    <li><img src="../images/Candidato.svg" title="Candidato"
                            onclick="imgSlider('0'); changeCircleColor('#9f3774'); changetext('0')"></li>
                    <li><img src="../images/Ods.svg" title="Objetivos de Desarrollo Sostenible"
                            onclick="imgSlider('1'); changeCircleColor('#e52860'); changetext('1')"></li>
                    <li><img src="../images/Pilares.svg" title="Pilares de Competencias"
                            onclick="imgSlider('2'); changeCircleColor('#e52860'); changetext('2')"></li>
                    <li><img src="../images/Empresa.svg" title="Empresa"
                            onclick="imgSlider('3'); changeCircleColor('#9f3774'); changetext('3')"></li>
                </ul>
            </div>
            <div class="close-popup">X</div>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script>

    $('.button').click(function () {
        $('.overlay').fadeIn();
    });

    $('.close-popup').click(function () {
        $('.overlay').fadeOut();
    });

    $(document).mouseup(function (e) {
        var popup = $('.popup');
        if (e.target != popup[0] && popup.has(e.target).length === 0) {
            $('.overlay').fadeOut();
        }
    });

    var products = [
        {
            "name": "Experiencia SER en Acción para el Candidato",
            "image": "../images/Candidato.svg",
            "description": "Has desarrollado competencias personales y laborales que te permiten ser efectivo en tu desempeño profesional. Igualmente, sabes la forma en que te gusta trabajar y el tipo de compañía. Cumplir con estas variables, te lleva a tener el trabajo y cargo soñado. Así queremos verte y presentarte. Con todo tu potencial y proyección laboral que te permitirán desempeñarte y avanzar dentro de mejor compañía para ti."
        },
        {
            "name": "Tu experiencia con SER en Acción te permite ser una Organización Sostenible",
            "image": "../images/Ods.svg",
            "description": "Cualquier acción que emprendamos que sume a los ODS (objetivos de desarrollo sostenible), nos permite como compañías responder de manera positiva a escenarios de equidad, de disminución de desigualdades y de la búsqueda de un trabajo más justo. El método de SER en Acción permite a nuestros clientes desarrollar su actividad de atracción y selección de candidatos aportando a los ODS 5,8 y 10."
        },
        {
            "name": "Pilares SER en Acción: Atraer el candidato ideal para el cargo ideal si es posible",
            "image": "../images/Pilares.svg",
            "description": "En épocas de cambio, el potencial de los candidatos y empleados es la mejor herramienta para adaptarse a los retos laborales y del mercado. Es así como reconocer las competencias e intereses de los candidatos es la manera de poder atraer y decidir sobre el más apto para la vacante disponible y conectar al candidato con la organización es viable. Así se garantiza un menor índice de rotación y se mantiene empleados más felices e identificados con su desempeño laboral y profesional."
        },
        {
            "name": "El modelo de reclutamiento sostenible 'SER en Acción' favorece en tiempo y efectividad en la empresa",
            "image": "../images/Empresa.svg",
            "description": "En la época actual la tecnología ha llevado los cargos a otro nivel. Requieres que los candidatos cumplan con habilidades y competencias que garanticen el logro de los objetivos y resultados esperados. Igualmente, requieres empleados comprometidos y que se sientan a gusto en la compañía. Reconocer el potencial de los candidatos es una de las mejores formas de contar con el colaborador idóneo, adaptativo y flexible con los cambios."
        },

    ];

    text = document.querySelector('.textBox');
    thumb = document.querySelector('.thumb');
    section = document.querySelector('other_section');
    var info = document.getElementById('info');
    var item = document.querySelectorAll('.navigation li a')

    function imgSlider(anything) {
        document.querySelector('.serenaccion').src = products[anything].image;
    }
    function changeCircleColor(color) {
        const circle = document.querySelector('.circle');
        const circle2 = document.getElementById('circle02');
        circle.style.background = color;
        circle2.style.background = color;
        info.style.background = color;
    }
    function blurEffect() {
        text.style.filter = "blur(10px)";
        thumb.style.filter = "blur(10px)";
        section.style.filter = "blur(10px)";
    }
    function changetext(i) {
        const producttitle = document.getElementById('contentBox-title');
        const contenttext = document.getElementById('contentBox-text');
        producttitle.innerText = products[i].name;
        contenttext.innerText = products[i].description;
    }
    function unblurEffect() {
        text.style.removeProperty('filter');
        thumb.style.removeProperty('filter');
        section.style.removeProperty('filter');
    }
    function addText() {
        setTimeout(function () {
            info.innerText = 'Conoce más sobre nuestros productos';
        }, 500);
    }
    function removeText() {
        info.innerText = 'Conoce más';
    }
    function menuEffect() {
        document.getElementById('circularMenu1').classList.toggle('active')
    }
    item.forEach(link => {
        link.addEventListener('click', (e) => {
            indicator(e.target);
        })
    })
    function toggleMenu() {
        var menutoggle = document.querySelector('.toggle');
        var menu = document.querySelector('.navigation');
        menutoggle.classList.toggle('active');
        menu.classList.toggle('active')
    }
    document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.main-menu').classList.toggle('show'));
</script>
</html>