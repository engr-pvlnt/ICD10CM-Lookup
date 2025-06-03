A sample ICD10CM lookup using the API from <br>
<b>https://clinicaltables.nlm.nih.gov/api/conditions/v3/search?terms=${encodedCondition}&sf=consumer_name&ef=icd10cm_codes,icd10cm</b>
<br>
Parameters:<br>
terms	=	(Required.) The search string (e.g., just a part of a word) for which to find matches in the list. More than one partial word can be present in "terms", in which case there is an implicit AND between them.<br>
sf = consumer_name, primary_name, word_synonyms, synonyms, term_icd9_code, term_icd9_text	A comma-separated list of fields to be searched.<br>
ef=	A comma-separated list of additional fields to be returned for each retrieved list item. (icd10cm_codes, icd10cm, term_icd9_code, term_icd9_text)<br>
