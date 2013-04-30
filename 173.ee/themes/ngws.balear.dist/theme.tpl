{XML}{XML_STYLE}{DOCTYPE}{XHTML}
<head>
{BASE}
<title>{PAGE_TITLE}</title>
{METATAGS} {JAVASCRIPT} {STYLE}
</head>
<body>
<div id="body-sub"></div>
	<div id="wrapper">
		<div id="container">
			<div id="header">
				<div id="headertop"></div>
				<div class="lao" id="headerleft">&nbsp;</div>
				<div class="lao" id="layout-header">{LAYOUT_HEADER}&nbsp;</div>
				<div class="lao" id="applogo"></div>
				<div class="lao" id="search-bar">{SEARCH_SEARCH_BOX}</div>
				<div class="lao" id="headerright"></div>
				<div id="headerbottom"></div>
			</div>
			<div id="main-content">
				<div id="sidepanel">
					<div id="sidepanel-n"></div>
					{MENU_MENU_1} {USERS_LOGIN_BOX} {DEFAULT} <!-- BEGIN notes -->
					<div id="notes-list">{NOTES_REMINDER}</div>	<!-- END notes -->
					<div id="sidepanel-s"></div>
				</div>
				<!-- BEGIN th -->
				<div id="theme-generator">{THEME_GENERATOR_HEADER}</div>
				<!-- END th -->
				<div id="body-content">{BODY}</div>
			</div>
			<div id="footer"><!-- BEGIN layout-footer -->{LAYOUT_FOOTER}<!-- END layout-footer --></div>
		</div>
	</div>
</body>
</html>