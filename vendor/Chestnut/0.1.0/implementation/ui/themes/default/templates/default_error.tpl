<html>
	<head>
		{literal}
		<style type="text/css">

		body
		{
			margin: 0 0 0 0;
			padding: 1em 1em 1em 1em;

			background-color: rgb(237, 58, 58);
		}

		div
		{
			width: 100%;
			margin-bottom: 1em;
			padding: 0.3em 0.3em 0.3em 0.3em;

			border: 2px dashed black;

			background-color: rgb(237, 213, 190);
		}

		div.title
		{
			margin-bottom: 0.5em;
			padding: 0 0 0 0;

			border: none;
			border-bottom: 1px solid black;

			font-weight: bold;
			font-size: 0.8em;
		}

		span.left_caption
		{
			padding-right: 0.5em;

			font-weight: bold;
			font-size: 1.1em;
		}

		</style>
		{/literal}

		<title>Chestnut default error</title>
	</head>

	<body>

		<div>
			<span class="left_caption">Triggered by:</span> {$type|capitalize}<br />
			<span class="left_caption">Severity:</span> {$severity|default:"undefined"}<br /><br />
			<span class="left_caption">Code:</span> {$code}<br />
			<span class="left_caption">Message:</span> {$message}
		</div>

<!--#############################################################################################-->

		{if $type == "exception"}

		<div>
			<div class="title">Throwed from</div>

			<span class="left_caption">File:</span> {$throwed_from_file}<br />
			<span class="left_caption">Line:</span> {$throwed_from_line}<br />
			<span class="left_caption">By call of:</span> {$throwed_from_by_call|default:"undefined"}()
		</div>

	<!--#############################################################################################-->

		{if $is_sql_exception === TRUE}

		<div>
			<div class="title">SQL Exception</div>

			<span class="left_caption">SQL Query:</span> {$sql_query}<br />
			<span class="left_caption">Error number:</span> {$sql_errno}<br />
			<span class="left_caption">Error string:</span> {$sql_error}
		</div>

		{/if}

	<!--#############################################################################################-->

		<div>
			<div class="title">Hardcoded in</div>

			<span class="left_caption">File:</span> {$hardcoded_in_file}<br />
			<span class="left_caption">Line:</span> {$hardcoded_in_line}<br />
			<span class="left_caption">Function:</span> {$hardcoded_in_function|default:"undefined"}()
		</div>

<!--#############################################################################################-->

		{elseif $type == "error"}

		<div>
			<span class="left_caption">File:</span> {$file}<br />
			<span class="left_caption">Line:</span> {$line}
		</div>

		{/if}

<!--#############################################################################################-->

	</body>
</html>