<?php /* #?ini charset="utf-8"?

[EmarsysAPI]
URL=https://api.emarsys.net/api/v2/
Username=
Secret=

FieldMappings[]
# user
FieldMappings[first_name]=1
FieldMappings[last_name]=2
FieldMappings[email]=3
FieldMappings[email_subscription]=31

# address
FieldMappings[street_address]=10
FieldMappings[city]=11
FieldMappings[state]=12
FieldMappings[zip]=13
FieldMappings[country]=14
FieldMappings[phone]=15
FieldMappings[fax]=16

# consumer profile
FieldMappings[i_am_currently_pregnant]=1510
FieldMappings[i_am_expecting_my_first_child]=1717
FieldMappings[i_am_expecting_my_next_child]=1718
FieldMappings[i_have_my_first_child]=2929
FieldMappings[i_have_more_than_one_child]=2930
FieldMappings[i_am_shopping_for_someone_else]=2931



# These fields must be mapped to Yes = 1, No = 2 when passing through to Emarsys
YesNoFields[]
YesNoFields[]=email_subscription
YesNoFields[]=i_am_currently_pregnant
YesNoFields[]=i_am_expecting_my_first_child
YesNoFields[]=i_have_my_first_child
YesNoFields[]=i_have_more_than_one_child
YesNoFields[]=i_am_shopping_for_someone_else


CountryIDMappings[]

CountryIDMappings[US]=185

CountryIDMappings[Austria]=10
CountryIDMappings[Germany]=65
CountryIDMappings[Switzerland]=168
CountryIDMappings[Liechtenstein]=100
CountryIDMappings[Afghanistan]=1
CountryIDMappings[Albania]=2
CountryIDMappings[Algeria]=3
CountryIDMappings[Andorra]=4
CountryIDMappings[Angola]=5
CountryIDMappings[Antigua and Barbuda]=6
CountryIDMappings[Argentina]=7
CountryIDMappings[Armenia]=8
CountryIDMappings[Australia]=9
CountryIDMappings[Azerbaijan]=11
CountryIDMappings[Bahamas]=12
CountryIDMappings[Bahrain]=13
CountryIDMappings[Bangladesh]=14
CountryIDMappings[Barbados]=15
CountryIDMappings[Belarus]=16
CountryIDMappings[Belgium]=17
CountryIDMappings[Belize]=18
CountryIDMappings[Benin]=19
CountryIDMappings[Bhutan]=20
CountryIDMappings[Bolivia]=21
CountryIDMappings[Bosnia and Herzegovina]=22
CountryIDMappings[Botswana]=23
CountryIDMappings[Brazil]=24
CountryIDMappings[Brunei Darussalam]=25
CountryIDMappings[Bulgaria]=26
CountryIDMappings[Burkina Faso]=27
CountryIDMappings[Burma]=28
CountryIDMappings[Burundi]=29
CountryIDMappings[Cambodia]=30
CountryIDMappings[Cameroon]=31
CountryIDMappings[Canada]=32
CountryIDMappings[Canary Islands]=201
CountryIDMappings[Cape Verde]=33
CountryIDMappings[Central African Republic]=34
CountryIDMappings[Chad]=35
CountryIDMappings[Chile]=36
CountryIDMappings[China]=37
CountryIDMappings[Colombia]=38
CountryIDMappings[Comoros]=39
CountryIDMappings[Congo]=40
CountryIDMappings[Congo, Democratic Republic of the]=41
CountryIDMappings[Costa Rica]=42
CountryIDMappings[Cote d'Ivoire]=43
CountryIDMappings[Croatia]=44
CountryIDMappings[Cuba]=45
CountryIDMappings[Cyprus]=46
CountryIDMappings[Czech Republic]=47
CountryIDMappings[Denmark]=48
CountryIDMappings[Djibouti]=49
CountryIDMappings[Dominica]=50
CountryIDMappings[Dominican Republic]=51
CountryIDMappings[East Timor]=258
CountryIDMappings[Ecuador]=52
CountryIDMappings[Egypt]=53
CountryIDMappings[El Salvador]=54
CountryIDMappings[Equatorial Guinea]=55
CountryIDMappings[Eritrea]=56
CountryIDMappings[Estonia]=57
CountryIDMappings[Ethiopia]=58
CountryIDMappings[Fiji]=59
CountryIDMappings[Finland]=60
CountryIDMappings[France]=61
CountryIDMappings[Gabon]=62
CountryIDMappings[Gambia, The]=63
CountryIDMappings[Georgia]=64
CountryIDMappings[Ghana]=66
CountryIDMappings[Gibraltar]=203
CountryIDMappings[Greece]=67
CountryIDMappings[Greenland]=198
CountryIDMappings[Grenada]=68
CountryIDMappings[Guatemala]=69
CountryIDMappings[Guinea]=70
CountryIDMappings[Guinea-Bissau]=71
CountryIDMappings[Guyana]=72
CountryIDMappings[Haiti]=73
CountryIDMappings[Honduras]=74
CountryIDMappings[Hong Kong]=205
CountryIDMappings[Hungary]=75
CountryIDMappings[Iceland]=76
CountryIDMappings[India]=77
CountryIDMappings[Indonesia]=78
CountryIDMappings[Iran]=79
CountryIDMappings[Iraq]=80
CountryIDMappings[Ireland]=81
CountryIDMappings[Israel]=82
CountryIDMappings[Italy]=83
CountryIDMappings[Jamaica]=84
CountryIDMappings[Japan]=85
CountryIDMappings[Jordan]=86
CountryIDMappings[Kazakhstan]=87
CountryIDMappings[Kenya]=88
CountryIDMappings[Kiribati]=89
CountryIDMappings[Korea, North]=90
CountryIDMappings[Korea, South]=91
CountryIDMappings[Kosovo]=259
CountryIDMappings[Kuwait]=92
CountryIDMappings[Kyrgyzstan]=93
CountryIDMappings[Laos]=94
CountryIDMappings[Latvia]=95
CountryIDMappings[Lebanon]=96
CountryIDMappings[Lesotho]=97
CountryIDMappings[Liberia]=98
CountryIDMappings[Libya]=99
CountryIDMappings[Lithuania]=101
CountryIDMappings[Luxembourg]=102
CountryIDMappings[Macau]=206
CountryIDMappings[Macedonia]=103
CountryIDMappings[Madagascar]=104
CountryIDMappings[Malawi]=105
CountryIDMappings[Malaysia]=106
CountryIDMappings[Maldives]=107
CountryIDMappings[Mali]=108
CountryIDMappings[Malta]=109
CountryIDMappings[Marshall Islands]=110
CountryIDMappings[Mauritania]=111
CountryIDMappings[Mauritius]=112
CountryIDMappings[Mexico]=113
CountryIDMappings[Micronesia]=114
CountryIDMappings[Moldova]=115
CountryIDMappings[Monaco]=116
CountryIDMappings[Mongolia]=117
CountryIDMappings[Montenegro]=202
CountryIDMappings[Morocco]=118
CountryIDMappings[Mozambique]=119
CountryIDMappings[Myanmar]=120
CountryIDMappings[Namibia]=121
CountryIDMappings[Nauru]=122
CountryIDMappings[Nepal]=123
CountryIDMappings[Netherlands Antilles]=204
CountryIDMappings[New Zealand]=125
CountryIDMappings[Nicaragua]=126
CountryIDMappings[Niger]=127
CountryIDMappings[Nigeria]=128
CountryIDMappings[Norway]=129
CountryIDMappings[Oman]=130
CountryIDMappings[Pakistan]=131
CountryIDMappings[Palau]=132
CountryIDMappings[Palestine]=133
CountryIDMappings[Panama]=134
CountryIDMappings[Papua New Guinea]=135
CountryIDMappings[Paraguay]=136
CountryIDMappings[Peru]=137
CountryIDMappings[Philippines]=138
CountryIDMappings[Poland]=139
CountryIDMappings[Portugal]=140
CountryIDMappings[Qatar]=141
CountryIDMappings[Romania]=142
CountryIDMappings[Russia]=143
CountryIDMappings[Rwanda]=144
CountryIDMappings[Samoa]=148
CountryIDMappings[San Marino]=149
CountryIDMappings[São Tomé and Príncipe]=150
CountryIDMappings[Saudi Arabia]=151
CountryIDMappings[Senegal]=152
CountryIDMappings[Serbia]=153
CountryIDMappings[Seychelles]=154
CountryIDMappings[Sierra Leone]=155
CountryIDMappings[Singapore]=156
CountryIDMappings[Slovakia]=157
CountryIDMappings[Slovenia]=158
CountryIDMappings[Solomon Islands]=159
CountryIDMappings[Somalia]=160
CountryIDMappings[South Africa]=161
CountryIDMappings[Spain]=162
CountryIDMappings[Sri Lanka]=163
CountryIDMappings[St. Kitts and Nevis]=145
CountryIDMappings[St. Lucia]=146
CountryIDMappings[St. Vincent and The Grenadines]=147
CountryIDMappings[Sudan]=164
CountryIDMappings[Suriname]=165
CountryIDMappings[Swaziland]=166
CountryIDMappings[Sweden]=167
CountryIDMappings[Syria]=169
CountryIDMappings[Taiwan]=170
CountryIDMappings[Tajikistan]=171
CountryIDMappings[Tanzania]=172
CountryIDMappings[Thailand]=173
CountryIDMappings[The Netherlands]=124
CountryIDMappings[Togo]=174
CountryIDMappings[Tonga]=175
CountryIDMappings[Trinidad and Tobago]=176
CountryIDMappings[Tunisia]=177
CountryIDMappings[Turkey]=178
CountryIDMappings[Turkmenistan]=179
CountryIDMappings[Tuvalu]=180
CountryIDMappings[Uganda]=181
CountryIDMappings[Ukraine]=182
CountryIDMappings[United Arab Emirates]=183
CountryIDMappings[United Kingdom]=184
CountryIDMappings[United States of America]=185
CountryIDMappings[Uruguay]=186
CountryIDMappings[Uzbekistan]=187
CountryIDMappings[Vanuatu]=188
CountryIDMappings[Vatican City]=189
CountryIDMappings[Venezuela]=190
CountryIDMappings[Vietnam]=191
CountryIDMappings[Virgin Islands]=199
CountryIDMappings[Western Sahara]=192
CountryIDMappings[Yemen]=193
CountryIDMappings[Yugoslavia]=194
CountryIDMappings[Zaire]=195
CountryIDMappings[Zambia]=196
CountryIDMappings[Zimbabwe]=197

*/ ?>
