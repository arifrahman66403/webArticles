<h1>Dashboard User</h1>
<p>Halo {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>
<a href="{{ route('logout') }}">Logout</a>
