<?php

  // <editor-fold desc=" General ">

	final class StringConst 
	{
		const EMPTY_STRING = "";
    const CRLF = "\r\n";
	}

  // </editor-fold>

  // <editor-fold desc=" FileHelper ">

	final class FileAccessModes
	{
			/* File Pointer beginning */
			const READ_ONLY = 'r';

			/* File Pointer beginning */
			const READ_WRITE = 'r+';

			/*
			** File Pointer beginning & truncate to 0 length.
			** If not exists, attempt to create.
			*/
			const WRITE_ONLY_CREATE = 'w';
			const READ_WRITE_CREATE = 'w+';
			const READ_ONLY_END = 'a';
			const READ_WRITE_END_CREATE = 'a+';
			const WRITE_ONLY_WARNING = 'x';

			/* Write only, throw E_Warning if file exists */
			const WRITE_ONLY_NO_TRUNCATE = 'c';
	}

	final class FileTypes
	{
			const ASCII = 1;
			const BINARY = 2;
	}

  // </editor-fold>

  // <editor-fold desc=" DBHelper ">

  class DBParamDir {
    const OUTPUT = 1;
    const INPUT = 2;
  };

  class DBType {
    const Numeric = 1;
    const AlphaNumeric = 2;
    const DateTime = 3;
  };

  final class DBStatus {
    const SUCCESS = 1;
    const FAILURE = 0;
  };

  final class Status {
    const Undefined = -1;
    const Active = 1;
    const Inactive = 0;
  }

  final class DBCommandType {
    const RAW = 1;
    const STOREDPROCEDURE = 2;
  };

  final class DBErrors {
    const CouldNotConnect = "Could Not connect to database. Please check username or password.";
  };

  // </editor-fold>

  // <editor-fold desc=" ListBase ">

  final class ListDataType {
    const STATICLIST=0;
    const SQLDATATABLE=1;
  }

  // </editor-fold>

?>
