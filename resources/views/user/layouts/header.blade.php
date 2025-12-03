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
                                <li class="nav-item" title="Point">
                                    <a class="nav-link" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-coins">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" />
                                            <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" />
                                            <path
                                                d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" />
                                            <path d="M3 6v10c0 .888 .772 1.45 2 2" />
                                            <path d="M3 11c0 .888 .772 1.45 2 2" />
                                        </svg> <span class="badge bg-warning text-dark">{{ Auth::user()->point }}</span>
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
