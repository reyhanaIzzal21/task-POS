<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><span>Urban</span> Starlet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="#membership">Membership</a></li>
                {{-- login button --}}
                @if (Route::has('login'))
                    @auth
                        {{-- if hasRole admin redirect to admin dashboard --}}
                        @if (Auth::user()->hasRole('admin'))
                            <li class="nav-item"><a class="btn btn-custom"
                                    href="{{ route('dashboard.admin') }}">Dashboard</a></li>
                        @else
                            {{-- display point user --}}
                            @if (Auth::user()->point)
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        Points: <span class="badge bg-warning text-dark">{{ Auth::user()->point }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item"><a class="btn btn-custom" href="{{ route('profile.edit') }}">Dashboard</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item"><a class="btn btn-custom" href="{{ route('login') }}">Be a Member</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>
