<a name="readme-top"></a>

<div align="center">

<img src="./public/img/LogoJ.png" alt="logo" width="250" height="250" />
  <br/>

  <h3><b>FORM JURISCONNECT</b></h3>

</div>

<!-- tabla de contenido -->

# 📗 Tabla de Contenido

- [📖 Sobre el proyecto](#about-project)
  - [🛠 Construir con](#built-with)
    - [Tech Stack](#tech-stack)
    - [Key Features](#key-features)
- [💻 Como empezar](#getting-started)
  - [Setup](#setup)
  - [Prerequisitos](#prerequisites)
  - [Instalacion](#install)
  - [Usos](#usage)
  - [Realizar pruebas](#run-tests)
- [👥 Autores](#authors)
- [🔭 Futuras Funciones](#future-features)
- [⭐️ Apoya nuesto proyecto](#support)
- [📝 Licencias](#license)

<!-- Descripcion de proyecto -->

# 📖 [Jurisconnect] <a name="about-project"></a>

**[Jurisconnect]** Es un proyecto destinado a mejorar la organización, registro, consulta, seguimiento y control de los procesos jurídicos dentro de la Dirección Jurídica del SENA. Se desarrollará utilizando tecnologías modernas y un enfoque de arquitectura monolítica, implementando en PHP con el framework Laravel. Esto permitirá una separación clara entre capas de presentación, lógica de negocio y acceso a datos. La base de datos será PostgreSQL y se utilizará Laravel Sail (Docker) como entorno de desarrollo.

### Tech Stack <a name="tech-stack"></a>

<li> Laravel sail </li>
<li> PHP </li>
<li> Javascript </li>
<li> CSS </li>
<li> tailwind </li>
<li> postgreSQL </li>
<li> docker </li>
<!-- Funciones -->

### Key Features <a name="key-features"></a>

- **[Base de Datos PostgreSQL]** - Almacenamiento robusto y escalable
- **[Docker con Laravel Sail]** - Entorno de desarrollo containerizado
- **[Gestión de Roles y Permisos]** - Control granular de accesos
- **[Upload de Archivos]** - Soporte para documentos PDF, Word y Excel
- **[Dashboard Estadístico]** - Visualización de métricas y estadísticas globales del sistema
- **[Responsive Design con Tailwind CSS]** - Interfaz moderna y adaptable
- **[Exportación de Reportes]** - Generación dinámica en múltiples formatos
- **[Notificaciones Internas]** - Sistema de alertas sobre actualizaciones en los procesos

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LIVE DEMO -->

<!-- ### 🚀 Live Demo <a name="live-demo"></a> -->

<!-- aqui va el github actions -->

<!-- - [Live Demo Link](	https://google.com) -->

<!-- <p align="right">(<a href="#readme-top">back to top</a>)</p> -->

<!-- Como empezar -->

## 💻 Como empezar <a name="getting-started"></a>

Para tener una copia local y correr el proyecto, Sigue estos pasos.

### Prerequisitos
para correr el proyecto, necesitas las sigiantes herramientas:
- [VS Code]
- [Git and GitHub]
- [Nodejs]
- [Laravel]
- [Blade]

### Setup

Clona este repositorio a tu carpeta designada:
```sh
 
 git clone https://github.com/Norelly-Salinas-Bre/MI_APP.git
 cd MI_APP
```

## Install

Instala este proyecto con:

Para dependencias JSON 
```sh
    npm install 
```

Composer 
```sh
    composer install
```

copia el archivo de configuracion 
```sh
    cp .env.example .env
```

### Realizar pruebas un test

Para realizar un test, realiza el siguiente comando:

Entrar a la carpeta del proyecto desde la terminal

inicia el entorno de desarrollo con laravel sail
```sh
     ./vendor/bin/sail up -d
```

Ejecuta las migraciones de base de datos 
```sh
    ./vendor/bin/sail artisan migrate
```

Ejecuta los seeders para datos de prueba opcional 
```sh
    ./vendor/bin/sail artisan db:seed
```

Correr el servidor 
```sh
    npm run dev
```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- autores -->

## 👥 Autores <a name="authors"></a>

- GitHub: [@Norelly-Salinas-Bre] (https://github.com/Norelly-Salinas-Bre)
- Github: [@santiago5627] (https://github.com/santiago5627)
- GitHub: [@victor3spitia] (https://github.com/Victor3spitia)


<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LICENSE -->

## 📝 Licencia <a name="license"></a>

This project is [MIT](/LICENSE.md) licensed.

<p align="right">(<a href="#readme-top">back to top</a>)</p>
