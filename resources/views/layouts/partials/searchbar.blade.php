<style>
#form-searchbar button, input {
    border: 0;
    padding: 0;
    margin: 0;
    box-sizing: border-box;
	font: 1em Hind, sans-serif;
	line-height: 1.5em;
    /* font-size: calc(16px + (24 - 16)*(100vw - 320px)/(1920 - 320)); */
}
#form-searchbar input {
	color: #171717;
}
#form-searchbar {
	display: flex;
	/* margin: auto; */
	justify-content: end;
	max-width: 100%;
}
#form-searchbar input { box-shadow: 0 0 0 0.4em #3d3d3d; inset; }
#form-searchbar input,
.search-btn, 
.search-btn:before, 
.search-btn:after {
	transition: all 0.25s ease-out;
}
#form-searchbar input,
.search-btn {
    background: #3d3d3d;
	width: 3em;
	height: 3em;
}
#form-searchbar input:invalid:not(:focus),
.search-btn {
	cursor: pointer;
}
#form-searchbar,
#form-searchbar input:focus,
#form-searchbar input:valid  {
	width: 100%;
}
#form-searchbar input:focus,
#form-searchbar input:not(:focus) + .search-btn:focus {
	outline: transparent;
}
#form-searchbar input {
	background: transparent;
	border-radius: 1.5em;
	box-shadow: 0 0 0 0.4em var(--bs-primary) inset;
	padding: 0.75em;
	transform: translate(0.5em,0.5em) scale(0.5);
	transform-origin: 100% 0;
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
}
#form-searchbar input::-webkit-search-decoration {
	-webkit-appearance: none;
}
#form-searchbar input:focus,
#form-searchbar input:valid {
	background: #fff;
	border-radius: 0.375em 0 0 0.375em;
	box-shadow: 0 0 0 0.1em #d9d9d9 inset;
	transform: scale(1);
}
.search-btn {
	background: var(--bs-primary);
	border-radius: 0 0.75em 0.75em 0 / 0 1.5em 1.5em 0;
	padding: 0.75em;
	position: relative;
	transform: translate(0.25em,0.25em) rotate(45deg) scale(0.25,0.125);
	transform-origin: 0 50%;
}
.search-btn:before, 
.search-btn:after {
	content: "";
	display: block;
	opacity: 0;
	position: absolute;
}
.search-btn:before {
	border-radius: 50%;
	box-shadow: 0 0 0 0.2em #f1f1f1 inset;
	top: 0.75em;
	left: 0.6em;
	width: 1.2em;
	height: 1.2em;
}
.search-btn:after {
	background: #f1f1f1;
	border-radius: 0 0.25em 0.25em 0;
	top: 50%;
	left: 46%;
	width: 0.75em;
	height: 0.25em;
	transform: translate(0.2em,0) rotate(45deg);
	transform-origin: 0 50%;
}
.search-btn span {
	display: inline-block;
	overflow: hidden;
	width: 1px;
	height: 1px;
}

/* Active state */
#form-searchbar input:focus + .search-btn,
#form-searchbar input:valid + .search-btn {
	background: var(--bs-primary);
	border-radius: 0 0.375em 0.375em 0;
	transform: scale(1);
}
#form-searchbar input:focus + .search-btn:before, 
#form-searchbar input:focus + .search-btn:after,
#form-searchbar input:valid + .search-btn:before, 
#form-searchbar input:valid + .search-btn:after {
	opacity: 1;
}
#form-searchbar input:focus + .search-btn:hover,
#form-searchbar input:valid + .search-btn:hover,
#form-searchbar input:valid:not(:focus) + .search-btn:focus {
	background: var(--bs-primary);
}
#form-searchbar input:focus + .search-btn:active,
#form-searchbar input:valid + .search-btn:active {
	transform: translateY(1px);
}

@media (max-width: 1199px) {
	#form-searchbar {
		display: none;
	}
}
@media screen and (prefers-color-scheme: dark) {
}
</style>

<form method="get" action="/book" id="form-searchbar" class="form-search search-bar">
	@csrf
    <input type="search" name="search" pattern=".*\S.*" autocomplete="off" value="{{(isset($_GET['search']) ? $_GET['search'] : '')}}" required>
    <button class="search-btn" type="submit">
        <span>Search</span>
    </button>
</form>