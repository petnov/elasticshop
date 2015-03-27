# ----------------------------------
# 1) convert .aff file to UTF-8
# 2) do `sed` magic
# 3) convert also .dic file to UTF-8
# 4) cleanup
# ----------------------------------
iconv -f ISO-8859-2 -t UTF-8 cs_CZ.aff > cs_CZ.aff.utf8
sed "1s/ISO8859-2/UTF-8/" cs_CZ.aff.utf8 > cs_CZ.aff.utf8.1
sed "2119s/$/áéíóúýůěrl\]nout/" cs_CZ.aff.utf8.1 > cs_CZ.aff.utf8
iconv -f ISO-8859-2 -t UTF-8 cs_CZ.dic > cs_CZ.dic.utf8
rm cs_CZ.aff.utf8.1
mv cs_CZ.aff.utf8 cs_CZ.aff
mv cs_CZ.dic.utf8 cs_CZ.dic

