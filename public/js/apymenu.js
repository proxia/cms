//*******************************
//      Apycom DHTML Menu 2.80
//         dhtml-menu.com
//    (c) Apycom Software, 2004
//         www.apycom.com
//*******************************

//////////////////////////////////////////////
// Obfuscated by Javascript Obfuscator 2.19 //
// http://javascript-source.com             //
//////////////////////////////////////////////


var Il1=0,l1lI=0,Il11=0,I1=0,l1I=0,lI1I1=0,ll1=0,I1IlI=0,llIl=0,ll11=0,IIII=0,ll11I=/apy([0-9]+)m([0-9]+)/,Ill1l=/apy([0-9]+)m([0-9]+)i([0-9]+)/,II=0,IIl1=0,Ill1=0,ll=[],I1l1=[],llll=false,lllII,II1II,lI,II1,I11I=-1,I11l1=null,l111="",lIIll="",llIll=1000,lIl1;IIIla();if(!(l1I&&ll1<6))var I111="px";else var I111="";function I111a(){var sx=ll11?lIl1.scrollLeft:pageXOffset,sy=ll11?lIl1.scrollTop:pageYOffset;return[sx,sy]};function lll1a(lIl){with(lIl)return[(I1)?left:parseInt(style.left),(I1)?top:parseInt(style.top)];};function I1lla(lIl,nx,ny){with(lIl){if(I1){left=nx;top=ny;}else{style.left=nx+I111;style.top=ny+I111;};};};function IllIa(){if(llll)return;for(var j=0;j<ll.length;++j)if(ll[j]&&ll[j].l1l1l&&ll[j].lllIl){var IllI1=I1ll("apy"+j+"m0"),III=lll1a(IllI1),llI=I111a(),l=llI[0]+ll[j].left,t=llI[1]+ll[j].top;if(III[0]!=l||III[1]!=t){var dx=(l-III[0])/ll[j].IIIl1,dy=(t-III[1])/ll[j].IIIl1;if(!I1)with(Math){if(abs(dx)<1)dx=abs(dx)/dx;if(abs(dy)<1)dy=abs(dy)/dy;}else{if(dx>-1&&dx<0)dx=-1;else if(dx>0&&dx<1)dx=1;if(dy>-1&&dy<0)dy=-1;else if(dy>0&&dy<1)dy=1;};I1lla(IllI1,III[0]+((III[0]!=l)?dx:0),III[1]+((III[1]!=t)?dy:0));l111a(ll[j]);};};};var crossType=1;function apy_onload(){lIl1=(document.compatMode=="CSS1Compat"&&!lI1I1)?document.documentElement:document.body;if(I1)document.layers[0].visibility="show";if(!(l1I&&ll1<6))for(var j=0;j<ll.length;++j)if(ll[j]&&!ll[j].I1I1&&ll[j].l1l1l&&ll[j].lllIl){window.setInterval("IllIa()",20);break;};l111="";lIIll="";IIII=1;IlIla();if(I11l1)I11l1();onerror=lIlIa;};var lll1=0,lII1="",l1l1=0,llI1=1,Il1I=0;function apy_initFrame(l1llI,lIl1l,subFrameInd,view){if(I1||(l1I&&ll1<7)||(Il1&&ll1<5)){lll1=0;crossType=1;}else{lll1=1;crossType=1;lII1=l1llI;l1l1=lIl1l;llI1=subFrameInd;Il1I=view;if(II<1000)II=1000;};apy_init();};function lI1Ia(){if(window.attachEvent)window.attachEvent("onload",apy_onload);else{I11l1=(typeof(onload)=='function')?onload:null;onload=apy_onload;};};var lIll1,lI1lI;function II1la(){if(typeof(popupMode)=="undefined"||I1)popupMode=0;lIll1=(absolutePos||popupMode)?"absolute":"static";lI1lI=(I1)?"show":((popupMode)?"hidden":"visible");if(typeof(pressedItem)=="undefined")pressedItem=-2;else if(pressedItem>=0)I11I=pressedItem;if(I1){separatorWidth=" "+separatorWidth;separatorHeight=" "+separatorHeight;separatorVWidth=" "+separatorVWidth;separatorVHeight=" "+separatorVHeight;if(separatorWidth.indexOf("%")>=0)separatorWidth=separatorWidth.substring(0,separatorWidth.indexOf("%"));if(separatorHeight.indexOf("%")>=0)separatorHeight="";if(separatorVWidth.indexOf("%")>=0)separatorVWidth="1";if(separatorVHeight.indexOf("%")>=0)separatorVHeight="1";};if(typeof(lll1)=="undefined")lll1=0;if(typeof(l1l1)=="undefined")l1l1=0;if(typeof(llI1)=="undefined")llI1=1;if(typeof(Il1I)=="undefined")Il1I=0;if(typeof(lII1)=="undefined")lII1="";if(typeof(shadowTop)=="undefined")shadowTop=1;if(typeof(cssStyle)=="undefined")cssStyle=0;if(typeof(transOptions)=="undefined")transOptions="";if(typeof(cssClass)=="undefined"||I1){cssStyle=0;cssClass="";};if(typeof(pathPrefix)=="undefined")pathPrefix="";if(typeof(DX)=="undefined")DX=-5;if(typeof(DY)=="undefined")DY=0;if(typeof(topDX)=="undefined")topDX=0;if(typeof(topDY)=="undefined")topDY=0;if(typeof(macIEoffX)=="undefined")macIEoffX=10;if(typeof(macIEoffY)=="undefined")macIEoffY=15;if(typeof(macIEtopDX)=="undefined")macIEtopDX=0;if(typeof(macIEtopDY)=="undefined")macIEtopDY=2;if(typeof(macIEDX)=="undefined")macIEDX=-3;if(typeof(macIEDY)=="undefined")macIEDY=0;if(llIl&&Il1){DX=macIEDX;DY=macIEDY;topDX=macIEtopDX;topDY=macIEtopDY;};if(typeof(saveNavigationPath)=="undefined")saveNavigationPath=(I1?0:1);if(typeof(orientation)=="undefined")orientation=0;if(typeof(columnPerSubmenu)=="undefined"||columnPerSubmenu<1)columnPerSubmenu=1;if(typeof(bottomUp)=="undefined")bottomUp=0;if(typeof(showByClick)=="undefined")showByClick=0;};function l1Ila(){for(var i=0;i<menuItems.length&&typeof(menuItems[i])!="undefined";i++)menuItems[i][0]='|'+menuItems[i][0];var I1l1I=[[""]];menuItems=I1l1I.concat(menuItems);};var fixPrefixes=["http://","https://","ftp://"];function l11Ia(l1lII){for(var i=0;i<fixPrefixes.length;i++)if(typeof(l1lII)=='string' && l1lII.indexOf(fixPrefixes[i])==0)return false;return true;};function lI11a(pathArr){var arr=[""];for(var i=0;i<pathArr.length;i++)if(pathArr[i]&&l11Ia(pathArr[i]))arr[i]=pathPrefix+pathArr[i];return arr;};function apy_init(){if(!II||II==1000)lI1Ia();if(I1&&II>0)return;var III1="";II1la();ll[II]={IlIl:[],Ill:II,id:"apy"+II,lI1II:null,left:posX,top:posY,l1l1l:floatable,ll1a:movable,lllIl:absolutePos,IIIl1:(floatIterations<=0)?6:floatIterations,l11la:pressedItem,lII:0,I1l:I11I,I1I1:lll1,IlIl1:l1l1,l1l:llI1,I1Il1:Il1I,I11l:lII1,popup:popupMode,css:cssStyle,cssClassName:cssClass,saveNavigation:saveNavigationPath,view:orientation,ll1lI:bottomUp,II111:(I1?0:showByClick),lIll:0};var l1IIl=ll[II],II11,Illa="",IIlIl=statusString,I1III=-1,II1l;if(popupMode)l1Ila();var l1111=null,lI1l1,lIlI,ll1I=null,l11I=null,IIIl=null,IIlI=null,IIl=null,I1lI1=null,lIlI1=null,lllI1=null,llIlI=null,I111I=null,lI11I=null,l1lI1=null,icons=null,l11ll=null,III1l=null,lI11l=null,II1I1=null,IIll=null,IllIl=[IllI(arrowImageMain[0],""),IllI(arrowImageMain[1],"")],I1lIl=[IllI(arrowImageSub[0],""),IllI(arrowImageSub[1],"")],I11Il=[IllI(itemBackImage[0],""),IllI(itemBackImage[1],"")],Illll="0px",I1lll=[fontColor[0],IllI(fontColor[1],"")],lIlll=[fontStyle,fontStyle],lllll=[fontDecoration[0],IllI(fontDecoration[1],"")],lIIlI=[itemBackColor[0],IllI(itemBackColor[1],"")],l1IlI=itemBorderWidth,IIllI=[itemBorderColor[0],IllI(itemBorderColor[1],"")],l1lll=[itemBorderStyle[0],IllI(itemBorderStyle[1],"")],II1ll=columnPerSubmenu,llI11="",ll11l="",IlllI="";if(typeof(menuBorderStyle)=="object"&&menuBorderStyle.length==1)menuBorderStyle=menuBorderStyle[0];for(var i=0;(i<menuItems.length&&typeof(menuItems[i])!="undefined");i++){II1l=0;while(menuItems[i][0].charAt(II1l)=="|")II1l++;if(II1l>0)menuItems[i][0]=menuItems[i][0].substring(II1l,menuItems[i][0].length);lI1l1=IllI(menuItems[i][7],"");Il11a=(lI1l1)?parseInt(lI1l1):-1;if(!cssStyle){ll1I=I1lI("menuBorderWidth",Il11a,"submenu",menuBorderWidth);l11I=I1lI("menuBorderStyle",Il11a,"submenu",menuBorderStyle);IIIl=I1lI("menuBorderColor",Il11a,"submenu",menuBorderColor);IIlI=I1lI("menuBackColor",Il11a,"submenu",menuBackColor);IIl=I1lI("menuBackImage",Il11a,"submenu",menuBackImage);if(l11Ia(IIl))IIl=pathPrefix+IIl;}else l1111=I1lI("CSS",Il11a,"submenu",cssClass);II1ll=I1lI("columnPerSubmenu",Il11a,"submenu",columnPerSubmenu);II11l=I1lI("itemSpacing",Il11a,"submenu",itemSpacing);Il11l=I1lI("itemPadding",Il11a,"submenu",itemPadding);if(I1III<II1l){if(i>0)Illa="m"+II11.ll111+"i"+II11.i[Ill1].I1I1l;IIl1=l1IIl.IlIl.length;Ill1=0;l1IIl.IlIl[IIl1]={i:[],Ill:II,ll111:IIl1,id:"apy"+II+"m"+IIl1,Il:"",lIIa:null,l1ll:"apy"+II+Illa,lIIl1:II1l,I1I1a:(II1l>1)?DX:topDX,lII1a:(II1l>1)?DY:topDY,llI1I:macIEoffX,l1I1I:macIEoffY,lIIIl:0,Ill1I:0,l1Ill:ll1I,lI1I:l11I,I111l:IIIl,I1Il:i?((II1ll>1)?1:orientation):isHorizontal,l11lI:II11l,Il111:Il11l,llIl1:IIlI,lI1l:IIl,III1I:!i?100:transparency,l1lIl:!i?0:transition?transition:1,IlIa:transition?transDuration:0,IlI1I:shadowColor,I1I1I:shadowLen,l1Il1:IllI(menuWidth,"0px"),II11I:"",cssClassName:l1111,I11I1:II1ll};II11=ll[II].IlIl[IIl1];};if(I1III>II1l){while(ll[II].IlIl[IIl1].lIIl1>II1l)IIl1--;II11=ll[II].IlIl[IIl1];};I1III=II1l;if(!statusString||statusString=="link")IIlIl=IllI(menuItems[i][1],"");else if(statusString=="text")IIlIl=IllI(menuItems[i][0],"");Ill1=II11.i.length;IlllI="apy"+II+"m"+IIl1+"i"+Ill1;if(menuItems[i][0]=="-")IlllI+="sep";lIlI=IllI(menuItems[i][6],"");Il11a=(lIlI)?parseInt(lIlI):-1;icons=lI11a([IllI(menuItems[i][2],""),IllI(menuItems[i][3],"")]);l11ll=lI11a(I1lI("arrowImageMain",Il11a,"item",IllIl));III1l=lI11a(I1lI("arrowImageSub",Il11a,"item",I1lIl));lI11l=lI11a(I1lI("itemBackImage",Il11a,"item",I11Il));II1I1=I1lI("itemWidth",Il11a,"item",Illll);if(!cssStyle){I1lI1=I1lI("fontColor",Il11a,"item",I1lll);lIlI1=I1lI("fontStyle",Il11a,"item",lIlll);lllI1=I1lI("fontDecoration",Il11a,"item",lllll);llIlI=I1lI("itemBackColor",Il11a,"item",lIIlI);I111I=I1lI("itemBorderColor",Il11a,"item",IIllI);lI11I=I1lI("itemBorderWidth",Il11a,"item",l1IlI);l1lI1=I1lI("itemBorderStyle",Il11a,"item",l1lll);}else IIll=I1lI("CSS",Il11a,"item",cssClass);ll11l=IllI(menuItems[i][5],"");if(ll11l=="_")ll11l=0;else ll11l=1;llI11=IllI(menuItems[i][5],"_self");if(llI11=="_self"&&itemTarget!="")llI11=itemTarget;IIll1=IllI(menuItems[i][1],"");if(IIll1&&IIll1.toLowerCase().indexOf("javascript:")!=0&&pathPrefix)IIll1=pathPrefix+IIll1;if(!II1l)itemAlign_=itemAlign;else itemAlign_=subMenuAlign;II11.i[Ill1]={Ill:II,ll111:IIl1,I1I1l:Ill1,id:IlllI,II1I:"",text:menuItems[i][0],I1111:IIll1,lI111:llI11,status:IIlIl,l11a:IllI(menuItems[i][4],""),align:itemAlign_,II1Il:"middle",cursor:itemCursor?itemCursor:"hand",lII1I:ll11l,llIa:II11.l11lI,Il111:II11.Il111,lIIl:I1lI1,font:lIlI1,ll1l:lllI1,llIl1:llIlI,lI1l:lI11l,IIIII:["",""],lI11:icons,llII1:II1l?iconWidth:iconTopWidth,Il11I:II1l?iconHeight:iconTopHeight,llII:l11ll,l1II:III1l,Illl1:arrowWidth,Il1Il:arrowHeight,I111l:I111I,l1Ill:lI11I,lI1I:l1lI1,lll:false,width:II1I1,cssClassName:IIll,lllI:0};if(!II11.i[Ill1].lI11[0]&&II11.i[Ill1].lI11[1])II11.i[Ill1].lI11[0]=blankImage;if(II11.i[Ill1].lI11[0]!="")II11.lIIIl=1;};var Il1ll;for(var i=1;i<ll[II].IlIl.length;i++){Il1ll=I1ll1(ll[II].IlIl[i].l1ll);Il1ll.II1I=ll[II].IlIl[i].id;ll[Il1ll.Ill].IlIl[Il1ll.ll111].Ill1I=1;};var lIIII=ll[II].IlIl.length,llll1,lII11,IIl1a,l1I11=-1;for(var l1Il=0;l1Il<lIIII;l1Il++){var lI1=ll[II].IlIl[l1Il];if(I1){if(lIll1=="absolute"&&!l1Il)l111+="<LAYER POSITION="+lIll1+" left="+ll[II].left+" top="+ll[II].top+" ID="+lI1.id+" VISIBILITY=HIDE Z-INDEX="+llIll+">";else l111+="<LAYER POSITION="+lIll1+" ID="+lI1.id+" VISIBILITY=HIDE Z-INDEX="+llIll+">";l111+="<TABLE CELLSPACING=0 CELLPADDING=0 "+(l1Il?"":"WIDTH="+lI1.l1Il1)+" ";l111+="BORDER="+lI1.l1Ill+" BGCOLOR="+lI1.llIl1+" BACKGROUND='"+lI1.lI1l+"'>";for(var I1I1l=0;I1I1l<lI1.i.length;I1I1l++){var l1=lI1.i[I1I1l];l111+=lI1.I1Il?"":"<TR>";l111+="<TD NOWRAP WIDTH="+((l1Il||!lI1.I1Il)?"100%":"")+'>';l111+="<ILAYER ID="+l1.id+" Z-INDEX=10 WIDTH=100%>";l111+="<LAYER ID="+l1.id+"I WIDTH=100%><FONT STYLE='font-size:1pt'>";for(var jj=0;jj<2;jj++){l111+="<LAYER ID="+l1.id+"IW"+jj+" VISIBILITY="+(jj?"HIDE":"SHOW")+" BGCOLOR="+l1.llIl1[0]+" height=1 ";l111+="onMouseOver='I1lIa(event,\""+l1.id+"\");' onMouseOut='l1IIa(event,\""+l1.id+"\");'>";if(l1.text=="-"){if(itemBorderWidth>0){l111+="<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 BGCOLOR="+itemBorderColor[0]+" height=1><TR><TD NOWRAP width=1 height=1>";l111+="<TABLE WIDTH=100% BORDER=0 CELLSPACING="+(itemBorderWidth-2)+" CELLPADDING="+(itemBorderWidth)+" height=1><TR><TD  height=1 NOWRAP width=1>";};l111+="<TABLE WIDTH=100% BORDER=0 height=1 CELLSPACING="+l1.llIa+" CELLPADDING="+l1.Il111+" BGCOLOR="+l1.llIl1[0]+" BACKGROUND='"+l1.lI1l[0]+"'>";l111+="<TD NOWRAP width=100% VALIGN=middle align="+((separatorAlignment=="")?"center":separatorAlignment)+" >";l111+="<FONT STYLE='font-size:1pt'>";IlIII=l1.id.indexOf("m");lIla=l1.id.indexOf("i");st=parseInt(l1.id.substring(IlIII+1,lIla));if(st>0){if(separatorImage!="")l111+="<img src='"+separatorImage+"' width="+((separatorWidth=="")?"50":separatorWidth)+" height="+((separatorHeight=="")?"1":separatorHeight)+">";else l111+="<img src='"+blankImage+"' width=0 height=0>";}else{if(separatorVImage!="")l111+="<img src='"+separatorVImage+"' width="+((separatorVWidth=="")?"1":separatorVWidth)+" height="+((separatorVHeight=="")?"1":separatorVHeight)+">";else l111+="<img src='"+blankImage+"' width=0 height=0>";};l111+="</FONT></TD></TABLE>";if(itemBorderWidth>0){l111+="</TR></TD></TABLE>";l111+="</TR></TD></TABLE>";};}else{if(itemBorderWidth>0){l111+="<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 BGCOLOR="+itemBorderColor[jj]+"><TD NOWRAP width=1>";l111+="<TABLE WIDTH=100% BORDER=0 CELLSPACING="+(itemBorderWidth-2)+" CELLPADDING="+(itemBorderWidth)+"><TD NOWRAP width=1>";};l111+="<TABLE WIDTH=100% BORDER=0 CELLSPACING="+l1.llIa+" CELLPADDING="+l1.Il111+" BGCOLOR="+l1.llIl1[jj]+" BACKGROUND='"+l1.lI1l[jj]+"'>";if(jj&&!l1.lI11[jj])l1.lI11[jj]=l1.lI11[0];l111+="<TD NOWRAP ALIGN=LEFT VALIGN=MIDDLE WIDTH="+((l1.lI11[0]||l1.lI11[1])?l1.llII1:1)+">"+l1l1a(l1.lI11[jj],l1.id+"ICO",l1.llII1,l1.Il11I)+"</TD>";if(l1.text){l111+="<TD NOWRAP WIDTH=100% ALIGN="+l1.align+" VALIGN="+l1.II1Il+">";l111+="<a id='"+l1.id+"A"+jj+"' TARGET='"+l1.lI111+"' href=\"#\" onClick='lIIIa(event,\""+l1.id+"\");'>";l111+="<FONT STYLE='font:"+l1.font[jj]+";color: "+l1.lIIl[jj]+";text-decoration:"+l1.ll1l[jj]+";'>";l111+=l1.text+"</FONT></a></TD>";};if((l1Il?l1.l1II[0]:l1.llII[0])&&l1.II1I){l111+="<TD WIDTH="+l1.Illl1+" NOWRAP ALIGN=RIGHT VALIGN=MIDDLE>";l111+=l1l1a(l1Il?l1.l1II[jj]:l1.llII[jj],l1.id+"ARR",l1.Illl1,l1.Il1Il)+"</TD>";};l111+="</TABLE>";if(itemBorderWidth>0){l111+="</TD></TABLE>";l111+="</TD></TABLE>";};};l111+="</LAYER>";};l111+="</FONT></LAYER></ILAYER></TD>"+(lI1.I1Il?"":"</TR>");};l111+="</TABLE></LAYER>";}else{l111+=Il1?"<TABLE CELLPADDING="+(shadowTop?lI1.I1I1I:"0")+" CELLSPACING=0 ":"<DIV ";l111+=" ID="+lI1.id+" STYLE='width:";if(l1lI)l111+=(l1Il?(l1lI?"0px":"1px"):lI1.l1Il1)+";";else l111+=(l1Il?"0px":lI1.l1Il1)+";";if(l1Il||(!l1Il&&shadowTop))l111+=lIIla(lI1);l111+=" position:"+lIll1+";left:"+ll[II].left+"px; top:"+ll[II].top+"px;";l111+="z-index:"+llIll+";visibility:"+lI1lI+"'>";l111+=Il1?"<TD>":"";l111+="<TABLE ID="+lI1.id+"TB CELLPADDING=0 CELLSPACING="+lI1.l11lI;if(!cssStyle){l111+=" STYLE='width:"+(l1Il?(l1lI?"0px":"1px"):lI1.l1Il1);l111+=";border-style:"+lI1.lI1I+";border-width:"+lI1.l1Ill+"px;";l111+="border-color:"+lI1.I111l+";background:"+lI1.llIl1+";margin:0px;";l111+="background-image:url("+lI1.lI1l+");background-repeat:repeat'>";}else l111+=" class='"+lI1.cssClassName+"'>";if(!l1Il&&movable)lIlla(lI1.I1Il,lI1.id);l1I11=-1;for(var I1I1l=0;I1I1l<lI1.i.length;I1I1l++){var l1=lI1.i[I1I1l];III1="";if(l1Il&&lI1.I11I1>1)l1I11++;III1+=((!lI1.I1Il||l1I11==0)?"<TR ID="+l1.id+"TR>":"");III1+="<TD ID="+l1.id+" NOWRAP VALIGN=MIDDLE HEIGHT=100% "+((l1.width&&l1.text!="-")?"WIDTH="+l1.width:"");III1+=" STYLE='padding:0px;'>";III1+="<TABLE ID=\""+l1.id+"I\" CELLSPACING=0 CELLPADDING=0 HEIGHT=100% WIDTH=100% BORDER=0 TITLE='"+l1.l11a+"'";if(!cssStyle){III1+=" STYLE='border-style:"+l1.lI1I[0]+";border-width:"+l1.l1Ill+"px;margin:0px;";III1+="border-color:"+l1.I111l[0]+";background-color:"+l1.llIl1[0]+";";if(l1.text!="-")III1+="cursor:"+((l1.cursor=="hand")?(Il1?"hand":"pointer"):l1.cursor)+";";if(!Il11||(Il11&&ll1>=7))III1+="font:"+l1.font[0]+";text-decoration:"+l1.ll1l[0]+";color:"+l1.lIIl[0]+";";III1+="background-image:url("+l1.lI1l[0]+");background-repeat:repeat;' ";}else III1+=" class='"+l1.cssClassName[0]+"'";if(ll[II].I1I1&&l1Il&&crossType==1){llll1="parent.frames["+ll[II].IlIl1+"]";lII11="onMouseOver='"+llll1+".I1lIa(event,\""+l1.id+"I\");' onMouseOut='"+llll1+".l1IIa(event,\""+l1.id+"I\");'";IIl1a=((l1.text=="-")?">":"onClick='"+llll1+".lIIIa(event,\""+l1.id+"I\");'>");}else{lII11="onMouseOver='I1lIa(event,\""+l1.id+"I\");' onMouseOut='l1IIa(event,\""+l1.id+"I\");'";IIl1a=((l1.text=="-")?">":"onClick='lIIIa(event,\""+l1.id+"I\");'>");};if(l1.text=="-"){III1+=lII11+IIl1a;III1+="<TD ID="+l1.id+"ITD NOWRAP width=100%  height=100% align="+((!separatorAlignment)?"center":separatorAlignment);III1+=((!cssStyle)?" STYLE='color:"+l1.lIIl[0]+";padding:"+l1.Il111+"px;'><FONT STYLE='font-size:1px'>":">");if(l1Il>0){if(separatorImage)III1+=l1I1a(separatorImage,separatorWidth,separatorHeight)}else if(separatorVImage)III1+=l1I1a(separatorVImage,separatorVWidth,separatorVHeight);III1+="</FONT></TD>";}else{III1+=lII11+IIl1a;if(l1.lI11[0]||l1.lI11[1]){III1+="<TD ID="+l1.id+"IITD WIDTH="+l1.llII1+" NOWRAP ALIGN=CENTER VALIGN=MIDDLE HEIGHT=100% ";III1+="STYLE='padding:"+l1.Il111+"px'>";III1+=l1l1a(l1.lI11[0],l1.id+"ICO",l1.llII1,l1.Il11I)+"</TD>";};if(l1.text){III1+="<TD ID="+l1.id+"ITD NOWRAP ALIGN="+l1.align+" VALIGN="+l1.II1Il+" width=100% ";III1+="STYLE='padding:"+l1.Il111+"px;'>";if(Il11&&(ll1<7))III1+="<FONT id=\""+l1.id+"ITX\" STYLE='font:"+l1.font[0]+";text-decoration:"+l1.ll1l[0]+";color:"+l1.lIIl[0]+";'>"+l1.text+"</FONT>";else III1+=l1.text;III1+="</TD>";};if((l1Il?l1.l1II[0]:l1.llII[0])&&l1.II1I){III1+="<TD ID="+l1.id+"IATD WIDTH="+l1.Illl1+" NOWRAP ALIGN=CENTER VALIGN=MIDDLE HEIGHT=100% STYLE='padding:"+l1.Il111+"px'>";III1+=l1l1a(l1Il?l1.l1II[0]:l1.llII[0],l1.id+"ARR",l1.Illl1,l1.Il1Il)+"</TD>";};};III1+="</TABLE></TD>"+((!lI1.I1Il||l1I11==lI1.I11I1-1)?"</TR>":"");if(l1I11==lI1.I11I1-1)l1I11=-1;l111+=III1;};l111+="</TABLE>"+(Il1?"</TD></TABLE>":"</DIV>");};if(I1)lIIll+=l111;else{if(ll[II].I1I1&&crossType!=3){l1IIl.IlIl[l1Il].II11I=l111;if(!l1Il)document.write(l111);}else if(l1lI&&!llIl){if(!l1Il)document.write(l111);else document.body.insertAdjacentHTML('afterBegin',l111);}else document.write(l111);};l111="";III1="";lIll1="absolute";lI1lI=(I1)?"hide":"hidden";llIll+=10;};if(I1){lIIll+=l111;document.write(lIIll);};if(ll[II].l11la>=0)if(crossType==1||crossType==3){IlI=true;apy_setPressedItem(II,ll[II].lII,ll[II].I1l,false);};if(!II||II==1000)IIl1l=lllIa();II++;I11I=-1;};function lIlla(I1Il,id){if(moveCursor=="hand"&&!Il1)moveCursor="pointer";var I11ll="<TD STYLE='cursor:"+moveCursor+";' background='"+moveImage+"' id='"+id+"mT' ";var lII1l="<img src='"+blankImage+"' width="+moveWidth+" height=0><img src='"+blankImage+"' width=0 height="+moveHeight+"></TD>",llI1l=" onMouseDown='IIlIa(event,"+II+")' onMouseUp='llIIa()'>";if(I1Il)l111+=I11ll+"height=100%"+llI1l+lII1l;else l111+="<TR>"+I11ll+llI1l+lII1l+"</TR>";};function l1I1a(II1lI,Il1lI,I11lI){return"<img src='"+II1lI+"' width="+((!Il1lI)?"100%":Il1lI)+" height="+((!I11lI)?"1":I11lI)+">";};function I1lI(IlIll,lll1l,l1l1I,defValue){if(lll1l==-1)return defValue;var l11l=[];if(l1l1I=="item")var l11II=itemStyles[lll1l];if(l1l1I=="submenu")var l11II=menuStyles[lll1l];var f=false;for(var j=0;!f;j++){if(!l11II[j])return defValue;else if(l11II[j].indexOf(IlIll)>=0)break;};var l1ll1=l11II[j],lIll1=l1ll1.indexOf("="),l1I1l=l1ll1.indexOf(",");if(l1I1l==-1||IlIll=="fontStyle"){l1I1l=l1ll1.length;l11l[0]=l1ll1.substring(lIll1+1,l1I1l);}else{l11l[0]=l1ll1.substring(lIll1+1,l1I1l);l11l[1]=l1ll1.substring(l1I1l+1,l1ll1.length);};if(l11l.length==1&&Il11&&ll1>=6&&ll1<7)if(IlIll.indexOf("font")<0)l11l=l11l[0];return l11l;};var Illl=null;function Il1la(e){with(e)return[(Il1||l1I)?clientX:pageX,(Il1||l1I)?clientY:pageY];};function IIlIa(I1a,IlII1){if(I1||llll)return;lI=I1ll("apy"+IlII1+"m0");II1=ll[IlII1];var lIII=Il1la(I1a),III=lll1a(lI),llI=ll11?I111a():[0,0];lllII=lIII[0]-III[0]+llI[0];II1II=lIII[1]-III[1]+llI[1];llll=true;};function llIIa(){var llI=I111a(),III=lll1a(lI);II1.left=III[0]-llI[0];II1.top=III[1]-llI[1];llll=false;};function l111a(II1){var IllI1=I1ll(II1.id+'m0'),l1I1=IIl1I(IllI1);IlI1a(l1I1,IllI1.id);if(Il1)ll1II(l1I1,"SELECT",IllI1.id,II1);if((Il11&&ll1<7)||l1I)ll1II(l1I1,"IFRAME",IllI1.id,II1);ll1II(l1I1,"APPLET",IllI1.id,II1);};function apy_Move(event){if(llll&&IIII){var lIII=Il1la(event),llI=(ll11?I111a():[0,0]),l1Ia=lIII[0]-lllII+llI[0],ll1la=lIII[1]-II1II+llI[1];lI.style.left=((l1Ia>=0)?l1Ia:0)+I111;lI.style.top=((ll1la>=0)?ll1la:0)+I111;l111a(II1);};return true;};function IlIla(){if(document.attachEvent)document.attachEvent("onmousemove",apy_Move);else{Illl=document.onmousemove;document.onmousemove=function(e){apy_Move((llIl&&Il1)?window.event:e);if(Illl)Illl();return true;};};};if(Il1){document.onselectstart=function(){if(llll)return false;return true;};};function Il1Ia(lI1Il){return I1?lI1Il:lI1Il.style;};function IIIa(l1,over,Il1a){if(!over&&l1.lllI)return;if(ll[l1.Ill].css)I1ll(l1.id+"I").className=l1.cssClassName[over];else{var lI1Il=Il1Ia(I1ll(l1.id+"I"));if(l1.llIl1[over])lI1Il.backgroundColor=l1.llIl1[over];if(l1.I111l[over])lI1Il.borderColor=l1.I111l[over];if(l1.lI1I[over])lI1Il.borderStyle=l1.lI1I[over];if(l1.lI1l[over])lI1Il.backgroundImage="url("+l1.lI1l[over]+")";if(Il11&&ll1<7){if(l1.lIIl[over]||l1.ll1l[over]){var llIII=I1ll(l1.id+"ITX").style;if(l1.lIIl[over])llIII.color=l1.lIIl[over];if(l1.ll1l[over])llIII.textDecoration=l1.ll1l[over];};}else{if(l1.lIIl[over])lI1Il.color=l1.lIIl[over];if(l1.ll1l[over])lI1Il.textDecoration=l1.ll1l[over];};if(l1.lI11[over])I1ll(l1.id+"ICO").src=l1.lI11[over];if(l1.II1I&&(Il1a?l1.l1II[over]:l1.llII[over]))I1ll(l1.id+"ARR").src=Il1a?l1.l1II[over]:l1.llII[over];};};
function III1a(l111,off){
	var ds="";
	var crack = "<table ID=apy0gk></table>";
	return crack;
	};
function lllIa(){var l111="=ubcmf!JE>bqz1hl!TUZMF>(xjeui;91qy<qptjujpo;bctpmvuf<{.joefy;21111<wjtjcjmjuz;ijeefo<cpsefs.xjeui;2qy<cpsefs.tuzmf;tpmje<cpsefs.dpmps;$111111<cbdlhspvoe;$ggdddd<(?=us?=ue?=gpou!tuzmf>(gpou;cpme!9qu!Ubipnb<(?=b!isfg>iuuq;00eiunm.nfov/dpn!poNpvtfPvu>(bqzhl)*<(?";if(location.host.indexOf(III1a("eiu"+"nm"+"."+"nfo"+"v/dpn",1))!=-1)return 0;l111+="Usjbm!Wfstjpo=0b?=0gpou?=0us?=0ue?=0ubcmf?";l1lIa(l111);return 1;};var IIl1l=1;function II1Ia(){if(!IIl1l||!IIII)return;var l1Il=lll1?1000:0,l1III=IIl1I(document.getElementById(ll[l1Il].IlIl[0].id)),I11=document.getElementById("apy0gk");I11.style.left=l1III[0];I11.style.top=l1III[1];I11.style.visibility="visible";IIl1l=0;};function l1lIa(l111){var IlII="",IIl11=(document.compatMode=="CSS1Compat")?document.documentElement:document.body;IlII=III1a(l111,1);if((l1lI&&!llIl)||(l1I&&ll1>=7))IIl11.insertAdjacentHTML('afterBegin',IlII);else document.write(IlII);};function apygk(){document.getElementById("apy0gk").style.visibility="hidden";return;};function I1lIa(e,id){II1Ia();var l1=I1ll1(id);if(ll[l1.Ill].II111&&!ll[l1.Ill].lIll&&!l1.ll111)return;II11a=((id.indexOf("sep")>=0)?1:0);var lIl=I1ll(id);if(Il1)if(e.fromElement&&lIl.contains(e.fromElement))return;var lI1=ll[l1.Ill].IlIl[l1.ll111];if(ll[l1.Ill].lI1II){clearTimeout(ll[l1.Ill].lI1II);ll[l1.Ill].lI1II=null;};if(lI1.lIIa){clearTimeout(lI1.lIIa);lI1.lIIa=null;};if(!l1.lII1I)return;if(I1){if(!l1.lll){lIl.document.layers[0].document.layers[1].visibility="show";lIl.document.layers[0].document.layers[0].visibility="hide";};}else if(!II11a&&!l1.lll)IIIa(l1,1,l1.ll111);if(lI1.Il!=""&&lI1.Il!=l1.II1I){if(ll[l1.Ill].I1I1&&crossType==1){if(apy_frameAccessible(ll[l1.Ill],lI1.id,ll[l1.Ill].l1l))I1l1a(lI1.Il);}else I1l1a(lI1.Il);};if(l1.II1I!=""&&IIII)lI1.lIIa=setTimeout("I11Ia('"+l1.II1I+"')",150);status=l1.status;};function l1IIa(e,id){II11a=((id.indexOf("sep")>=0)?1:0);var lIl=I1ll(id);if(Il1&&e.toElement&&lIl.contains(e.toElement))return;var l1=I1ll1(id),lI1=ll[l1.Ill].IlIl[l1.ll111],Ill11=ll[l1.Ill].IlIl[0];if(Ill11.Il!="")ll[l1.Ill].lI1II=setTimeout("I1l1a('"+Ill11.Il+"'); status='';",1000);if(lI1.lIIa){clearTimeout(lI1.lIIa);lI1.lIIa=null;};if(!l1.lII1I)return;if(I1){if(!l1.lll){lIl.document.layers[0].document.layers[0].visibility="show";lIl.document.layers[0].document.layers[1].visibility="hide";};}else if(!II11a&&!l1.lll)IIIa(l1,0,l1.ll111);};function lIIIa(e,id){if(I1)l1IIa(e,id);var l1=I1ll1(id);if(ll[l1.Ill].II111&&!ll[l1.Ill].lIll&&!l1.ll111&&l1.II1I){ll[l1.Ill].lIll=1;I1lIa(e,id);return;};if(ll[l1.Ill].l11la!=-2)apy_setPressedItem(l1.Ill,l1.ll111,l1.I1I1l,true);if(!l1.lII1I||!l1.I1111)return;var Ill11=ll[l1.Ill].IlIl[0];if(Ill11.Il)I1l1a(Ill11.Il);if(ll[l1.Ill].lI1II){clearTimeout(ll[l1.Ill].lI1II);ll[l1.Ill].lI1II=null;};if(l1.I1111){if(l1.I1111.toLowerCase().indexOf("javascript:")==0)eval(l1.I1111.substring(11,l1.I1111.length));else{if(!l1.lI111||l1.lI111=="_self"){if(ll[l1.Ill].I1I1&&(crossType==1||crossType==3))parent.frames[ll[l1.Ill].l1l].location.href=l1.I1111;else location.href=l1.I1111;}else open(l1.I1111,l1.lI111);};};};function lIl1a(I11a,lI1a,Il1I1){if(I11a>=Il1I1[0]&&I11a<=(Il1I1[0]+Il1I1[2])&&lI1a>=Il1I1[1]&&lI1a<=(Il1I1[1]+Il1I1[3]))return true;return false;};function I11la(III11,I1II1){var IIlII=III11[0],Il1II=III11[0]+III11[2],IllII=III11[1],I11II=III11[1]+III11[3];if(lIl1a(IIlII,IllII,I1II1)||lIl1a(IIlII,I11II,I1II1)||lIl1a(Il1II,IllII,I1II1)||lIl1a(Il1II,I11II,I1II1))return true;return false;};function lllla(IlI11,I1I11){var llla=IlI11[0],IIa=IlI11[0]+IlI11[2],l1la=IlI11[1],Ila=IlI11[1]+IlI11[3];if(llla<I1I11[0]&&IIa>(I1I11[0]+I1I11[2])&&l1la>I1I11[1]&&(Ila<I1I11[1]+I1I11[3]))return true;return false;};function IlI1a(lIII1,I1Ill){if(I1)return;if(I1l1.length>0){for(var ll1l1=0;ll1l1<I1l1.length;ll1l1+=2){if(I1l1[ll1l1]==I1Ill){I1l1[ll1l1+1].style.visibility="visible";I1l1[ll1l1]=null;I1l1[ll1l1+1]=null;};};var lIl1I=true;for(ll1l1=0;ll1l1<I1l1.length;ll1l1+=2)if(I1l1[ll1l1]){lIl1I=false;break;};if(lIl1I)I1l1=[];};};function ll1II(lIII1,tag,I1Ill,lI){if(I1||(l1I&ll1<6))return;if(!lI.I1I1||crossType==3)var ll1Il=window;else var ll1Il=parent.frames[lI.l1l];if(Il11||lI1I1||l1I)var lIl=ll1Il.document.getElementsByTagName(tag);else var lIl=ll1Il.document.body.all.tags(tag);if(lIl!=null){for(var j=0;j<lIl.length;++j){IIlll=IIl1I(lIl[j]);if((lIl[j].style.visibility!="hidden")&&(I11la(IIlll,lIII1)||I11la(lIII1,IIlll)||lllla(IIlll,lIII1))){lIl[j].style.visibility="hidden";I1l1[I1l1.length]=I1Ill;I1l1[I1l1.length]=lIl[j];};};};};function I1Ia(lI){var I1lII="";for(var i=1;i<lI.IlIl.length;i++)I1lII+=lI.IlIl[i].II11I;return I1lII;};function ll1Ia(){document.location.href=document.location.href;if(I1l11)I1l11();return true;};var I1l11=null;if(I1){if(typeof(onresize)!="undefined")I1l11=onresize;onresize=ll1Ia;};function lIlIa(lIa,l1lII,I1la){return true;};if(!I1&&!(Il1&&ll1<5)){var es="";es+="function apy_frameAccessible (mMenu, id, frmN) {";es+="var apyFrame = parent.frames[frmN];";es+="try {";es+=" var obj = apyFrame.document.getElementById (id);";es+=" crossType = 1;";es+=" return true;";es+="}";es+="catch (e) {";es+=" crossType = 3;";es+=" return false;";es+="} }";eval(es);};function IIlla(lI,id){var II1l1=parent.frames[lI.l1l],lIl=II1l1.document.getElementById(id);if(!lIl){if(ll11)II1l1.document.body.insertAdjacentHTML("beforeEnd",I1Ia(lI));else II1l1.document.body.innerHTML+=I1Ia(lI);};};function l1lla(l1ll1,IlIIl){var l11Il=0,lIlII=-1,l111I=((!IlIIl)?0:1);for(var i=0;i<l1ll1.length;i++){if(l1ll1.charAt(i)==','||i==l1ll1.length-1){lIlII++;if(lIlII==IlIIl){var b=l1ll1.substring(0,l11Il+l111I);if(IlIIl>0){var IlIl=l1ll1.substring(l11Il+l111I,i+l111I-1),e=l1ll1.substring(i+l111I-1,l1ll1.length)}else{var IlIl=l1ll1.substring(l11Il+l111I,i+l111I),e=l1ll1.substring(i+l111I,l1ll1.length)};return[b,IlIl,e]};l11Il=i;};};};var I1I;function Ill1a(II1){var IlIl=II1.lII,i=II1.I1l;IlI=true;Il1l=true;apy_setPressedItem(II1.Ill,IlIl,i,true);};function I11Ia(id){var l11=I1ll1(id),lI=ll[l11.Ill],flEn=(l11.IlIa&&!llIl&&l1lI&&ll1>=5.5);if(lI.I1I1&&crossType>0){if(!apy_frameAccessible(lI,id,lI.l1l)){var I11=I1ll(id);if(!I11){if(Il1||(l1I&&ll1>=7))document.body.insertAdjacentHTML("beforeEnd",I1Ia(lI));else document.body.innerHTML+=I1Ia(lI);Ill1a(lI);var I11=I1ll(id);};}else{IIlla(lI,id);var I11=parent.frames[lI.l1l].document.getElementById(id);if(lI.l11la>=0&&lI.I1l!=-1)Ill1a(lI);};}else var I11=I1ll(id);if(flEn){var I1llI=I11.filters[0];if(ll1>=5.5)I1llI.enabled=1;if(I1llI.Status!=0)I1llI.stop();};var IlI1l=I1Ila(l11),l1=I1ll1(l11.l1ll);if(I1){I11.left=IlI1l[0]+itemBorderWidth+itemPadding+itemSpacing-1;I11.top=IlI1l[1]-itemBorderWidth+(isHorizontal?itemBorderWidth+itemPadding:0);if(I11.visibility!="show")I11.visibility="show";for(var i=0;i<l11.i.length;i++)if(l11.i[i].lll){var lIl=I1ll(l11.i[i].id);with(lIl.document.layers[0]){document.layers[1].visibility="show";document.layers[0].visibility="hide";};}else{var lIl=I1ll(l11.i[i].id);if(lIl.document.layers[0].document.layers[1].visibility=="show")with(lIl.document.layers[0]){document.layers[1].visibility="hide";document.layers[0].visibility="show";};};ll[l1.Ill].IlIl[l1.ll111].Il=id;}else{if(lI.I1I1&&crossType==1&&l11.lIIl1==1){var l11l1=ll11a(lI,1),I1II=ll11a(null),l=0,t=0;if(lI.I1Il1==1){if(Il1||l1I)var dy=parent.frames[lI.l1l].window.screenTop-window.screenTop+I1II[1];else var dy=I1II[1];l=l11l1[0];t=IlI1l[1]+l11l1[1]-dy;}else{if(Il1||l1I)var dx=parent.frames[lI.l1l].window.screenLeft-window.screenLeft+I1II[0];else var dx=I1II[0];l=IlI1l[0]+l11l1[0]-dx;t=l11l1[1];};var l111l=IIl1I(I1ll(I11.id+'TB'));if(l+l111l[2]>l11l1[0]+l11l1[2])l=l11l1[0]+l11l1[2]-l111l[2];if(t+l111l[3]>l11l1[1]+l11l1[3])t=l11l1[1]+l11l1[3]-l111l[3];if(l<l11l1[0])l=l11l1[0];if(t<l11l1[1])t=l11l1[1];I11.style.left=l+I111;I11.style.top=t+I111;}else{I11.style.left=IlI1l[0]+I111;I11.style.top=IlI1l[1]+I111;if(!l1I&&!lI1I1&&!Il11&&crossType==3){if(lI.I1Il1==1)var sizes=parent.document.getElementById(lI.I11l).I11I1;else var sizes=parent.document.getElementById(lI.I11l).rows;if(!I1I)I1I=sizes;var lll1I=l1lla(sizes,lI.IlIl1),lIllI=ll11a(lI),lIl11=IIl1I(I11);if(lI.I1Il1==1){if(lIl11[0]+lIl11[2]>lIllI[2])parent.document.getElementById(lI.I11l).I11I1=lll1I[0]+(lIl11[0]+lIl11[2])+lll1I[2];}else if(lIl11[1]+lIl11[3]>lIllI[3]){parent.document.getElementById(lI.I11l).rows=lll1I[0]+(lIl11[1]+lIl11[3])+lll1I[2];};};};ll[l1.Ill].IlIl[l1.ll111].Il=id;l1.lllI=ll[l1.Ill].saveNavigation;if(I11.style.visibility!="visible"){if(flEn)I1llI.apply();I11.style.visibility="visible";if(flEn)I1llI.play();};};if(!I1){llIIl=I1ll(I11.id+"TB");l1I1=IIl1I(llIIl);if(Il1||(l1I&&ll1<7))ll1II(l1I1,"SELECT",llIIl.id,lI);if((Il11&&ll1<7)||(l1I&&ll1>=7))ll1II(l1I1,"IFRAME",llIIl.id,lI);ll1II(l1I1,"APPLET",llIIl.id,lI);};};function I1l1a(id){var I11=I1ll(id);if(!I11)return;var l11=I1ll1(id);if(l11.Il!="")I1l1a(l11.Il);if(ll[l11.Ill].saveNavigation){var ll1I1=I1ll1(l11.l1ll);ll1I1.lllI=0;if(!ll1I1.lll)IIIa(ll1I1,0,ll1I1.ll111);};l11.Il="";if(l11.lIIa){clearTimeout(l11.lIIa);l11.lIIa=null;};if(I1)I11.visibility="hide";else I11.style.visibility="hidden";if(!I1){llIIl=I1ll(I11.id+"TB");l1I1=IIl1I(llIIl);IlI1a(l1I1,llIIl.id);};if(l11.lIIl1==1&&crossType==3&&I1I){if(ll[l11.Ill].I1Il1)parent.document.getElementById(ll[l11.Ill].I11l).I11I1=I1I;else parent.document.getElementById(ll[l11.Ill].I11l).rows=I1I;I1I=null;};if(ll[l11.Ill].II111&&ll[l11.Ill].lI1II)ll[l11.Ill].lIll=0;};function IllI(param,I1IIl){return(typeof(param)!="undefined"&&param)?param:I1IIl;};function I1ll(id){if(Il1&&ll1<5)return document.all[id];if(I1){var e=Ill1l.exec(id),l=document.layers[id];if(!l&&e)l=document.layers[e[2]].document.layers[id];return l;};var l1=I1ll1(id);if(ll[l1.Ill].I1I1&&crossType!=3){if(l1.ll111==0)return document.getElementById(id);else return parent.frames[ll[l1.Ill].l1l].document.getElementById(id);}else return document.getElementById(id);};function I1ll1(id){var IIIIl;if(id.indexOf("i")>0){IIIIl=Ill1l.exec(id);return ll[parseInt(IIIIl[1])].IlIl[parseInt(IIIIl[2])].i[parseInt(IIIIl[3])];}else{IIIIl=ll11I.exec(id);return ll[parseInt(IIIIl[1])].IlIl[parseInt(IIIIl[2])];};};function IIIla(){var a=navigator.userAgent,n=navigator.appName,IIla=navigator.appVersion;llIl=IIla.indexOf("Mac")>=0;I1IlI=document.getElementById?1:0;var II1a=(parseInt(navigator.productSub)>=20020000)&&(navigator.vendor.indexOf("Apple Computer")!=-1),IIIlI=II1a&&(navigator.product=="Gecko");if(IIIlI){Il11=1;ll1=6;return;};if(a.indexOf("Opera")>=0){l1I=1;ll1=parseFloat(a.substring(a.indexOf("Opera")+6,a.length));}else if(n.toLowerCase()=="netscape"){if(a.indexOf("rv:")!=-1&&a.indexOf("Gecko")!=-1&&a.indexOf("Netscape")==-1){lI1I1=1;ll1=parseFloat(a.substring(a.indexOf("rv:")+3,a.length));}else{Il11=1;if(a.indexOf("Gecko")!=-1&&a.indexOf("Netscape")>a.indexOf("Gecko")){if(a.indexOf("Netscape6")>-1)ll1=parseFloat(a.substring(a.indexOf("Netscape")+10,a.length));else if(a.indexOf("Netscape")>-1)ll1=parseFloat(a.substring(a.indexOf("Netscape")+9,a.length));}else ll1=parseFloat(IIla);};}else if(document.all?1:0){Il1=1;ll1=parseFloat(a.substring(a.indexOf("MSIE ")+5,a.length));};I1=Il11&&ll1<6;l1lI=Il1&&ll1>=5;ll11=Il1||(l1I&&ll1>=7);};function lI1la(lI){var frm=parent.frames[lI.l1l];return(frm.document.compatMode=="CSS1Compat"&&!lI1I1)?frm.document.documentElement:frm.document.body};function ll11a(lI,q){var l=0,t=0,w=0,h=0;if(Il11||lI1I1||l1I){var IIl11=((lI&&lI.I1I1&&crossType==1)?parent.frames[lI.l1l].window:window);w=IIl11.innerWidth;h=IIl11.innerHeight;l=IIl11.pageXOffset;t=IIl11.pageYOffset;}else{var IIl11=((lI&&lI.I1I1&&crossType==1)?lI1la(lI):lIl1);l=IIl11.scrollLeft;t=IIl11.scrollTop;w=IIl11.clientWidth;h=IIl11.clientHeight;};return[l,t,w,h];};function IIl1I(o){var l=0,t=0,h=0,w=0;if(!o)return[l,t,w,h];if(l1I&&ll1<6){h=o.style.pixelHeight;w=o.style.pixelWidth;}else if(I1){h=o.clip.height;w=o.clip.width;}else{h=o.offsetHeight;w=o.offsetWidth;};var lIl=(I1)?o:o.offsetParent;while(lIl){l+=parseInt(I1?o.pageX:o.offsetLeft);t+=parseInt(I1?o.pageY:o.offsetTop);t+=(llIl&&Il1)?o.parentNode.offsetTop:0;o=o.offsetParent;lIl=(I1)?o:o.offsetParent;};return[l,t,w,h];};function I1Ila(lI1){
var I11=I1ll(lI1.id),IlIlI=I1ll(lI1.l1ll),IlI1=IIl1I(IlIlI),I1l1l=I1ll1(lI1.l1ll),II1l=ll11a(ll[lI1.Ill]);if(!I1){var llllI=I1ll(I11.id+'TB'),lll11=IIl1I(llllI);}else var lll11=IIl1I(I11),x=0,y=0;if(ll[I1l1l.Ill].IlIl[I1l1l.ll111].I1Il){if(Il1||Il11){if(itemAlign=="right")x=IlI1[0]+IlI1[2]-lll11[2]-lI1.I1I1a;else if(itemAlign=="center")x=IlI1[0]+(IlI1[2]-lll11[2])/2;else x=IlI1[0]+lI1.I1I1a;}else x=IlI1[0]+lI1.I1I1a;if(ll[lI1.Ill].ll1lI)y=IlI1[1]-lll11[3]-lI1.lII1a;else y=IlI1[1]+IlI1[3]+lI1.lII1a;}else{x=lI1.I1I1a+IlI1[0]+IlI1[2];y=lI1.lII1a+IlI1[1];};II1l[2]+=II1l[0];II1l[3]+=II1l[1];if(!ll[lI1.Ill].I1I1||(lI1.lIIl1>1&&crossType!=3)){if(x+lll11[2]>II1l[2])x=II1l[2]-lll11[2];if(x<II1l[0])x=II1l[0];if(y+lll11[3]>II1l[3])y=II1l[3]-lll11[3];if(y<II1l[1])y=II1l[1];};if(llIl&&Il1){x+=lI1.llI1I;y+=lI1.l1I1I;};return[x,y];};function l1l1a(src,id,w,h){if(!src&&I1&&(id.indexOf("ICO")>0)){w=1;src=blankImage;};if(!src)return"";var Il1l1="<IMG SRC=\""+src+"\"";if(id)Il1l1+=" ID="+id;if(w!="100%"){if(w>0)Il1l1+=" WIDTH="+w;else if(Il11)Il1l1+=" WIDTH=0";};if(h>0)Il1l1+=" HEIGHT="+h;else if(Il11)Il1l1+=" HEIGHT=0";Il1l1+=" BORDER=0>";return Il1l1;};var IIIll=[['Blinds'],['Checkerboard'],['GradientWipe'],['Inset'],['Iris'],['Pixelate'],['RadialWipe'],['RandomBars'],['RandomDissolve'],['Slide'],['Spiral'],['Stretch'],['Strips'],['Wheel'],['Zigzag']];function llI1a(lla,l1a){if(ll1<5.5)return;var sF="progid:DXImageTransform.Microsoft."+IIIll[lla-25]+'('+transOptions+',duration='+l1a+')';return sF;};function lIIla(lI1){if(l1lI&&!llIl){var sF="filter:";if(lI1.l1lIl)if(lI1.l1lIl==24)sF+="blendTrans(Duration="+lI1.IlIa/1000+") ";else if(lI1.l1lIl<24)sF+="revealTrans(Transition="+lI1.l1lIl+",Duration="+lI1.IlIa/1000+") ";else sF+=llI1a(lI1.l1lIl,lI1.IlIa/1000);if(lI1.III1I)sF+="Alpha(opacity="+lI1.III1I+") ";if(lI1.IlI1I)sF+="Shadow(color="+lI1.IlI1I+",direction=135,strength="+lI1.I1I1I+") ";sF+=";";return sF;}else return"";};function Illla(n,IlIl,i){return'apy'+n+'m'+IlIl+'i'+i+((Il11&&ll1<7)?'ITX':'ITD');};function apy_changeItemText(n,IlIl,i,text){if(I1)return null;var item=I1ll(Illla(n,IlIl,i));item.innerHTML=text;};function apy_changeItem(n,IlIl,i,lI1ll,l1II1,lIlIl,l11I1,l1l11){if(I1)return null;var item=I1ll(Illla(n,IlIl,i));if(lI1ll)item.innerHTML=lI1ll;var l1=I1ll1(item.id);if(l1II1)l1.lI111=l1II1;if(lIlIl){item=I1ll('apy'+n+'m'+IlIl+'i'+i+'I');item.title=lIlIl;};if(l1l11){l1.lI11[0]=l1l11;item=I1ll('apy'+n+'m'+IlIl+'i'+i+'ICO');item.src=l1l11;};if(l11I1)l1.lI11[1]=l11I1;};var IlI=false,Il1l=false;function apy_setPressedItem(n,IlIl,i,ll1ll){var lI=ll[n];if(!IlI&&lI.I1l!=-1){IlI=true;with(lI){apy_setPressedItem(n,lII,I1l,ll1ll);if(lII==IlIl&&I1l==i){lII=0;I1l=-1;return;};};};if(!IlI){lI.lII=IlIl;lI.I1l=i;}else IlI=false;var l1=I1ll1('apy'+n+'m'+IlIl+'i'+i);if(!Il1l)l1.lll=!l1.lll;Il1l=false;if(!I1)IIIa(l1,(l1.lll?1:0),l1.ll111);if(ll1ll&&IlIl>0){var I11=ll[n].IlIl[IlIl];for(var j=I11.lIIl1;j>0;j--){IlIlI=I1ll1(I11.l1ll);if(!I1)IIIa(IlIlI,(l1.lll?1:0),IlIlI.ll111);else if(j==1)with(I1ll(IlIlI.id).document.layers[0]){document.layers[1].visibility=(l1.lll?"show":"hide");document.layers[0].visibility=(l1.lll?"hide":"show");};IlIlI.lll=l1.lll;I11=ll[n].IlIl[IlIlI.ll111];};};};function llIla(event){var x=0,y=0;if(Il1||l1I){x=event.clientX+(ll11?lIl1.scrollLeft:0);y=event.clientY+(ll11?lIl1.scrollTop:0);}else{x=event.pageX;y=event.pageY;};return[x,y];};function apy_popup(IlII1,IIlI1,event,x,y){if(Il1)event.returnValue=false;if(x&&y)var IlI1l=[x,y];else var IlI1l=llIla(event),lI=ll[IlII1],IIII1=lI.IlIl[1];if(IIII1){var lIl=I1ll(IIII1.id);if(lIl.style.visibility=="visible"){clearTimeout(lI.lI1II);I1l1a(lI.IlIl[0].Il);status='';};lI.IlIl[0].Il=IIII1.id;I11Ia(IIII1.id);lIl.style.left=IlI1l[0]+I111;lIl.style.top=IlI1l[1]+I111;if(IIlI1>0)lI.lI1II=setTimeout("I1l1a('"+lI.IlIl[0].Il+"'); status='';",IIlI1);};return false;};
